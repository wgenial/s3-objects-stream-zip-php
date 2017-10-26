<?php
  namespace WGenial\S3ObjectsStreamZip;

  use Aws\S3\Exception\S3Exception;
  use Aws\S3\S3Client;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;
  use ZipStream\ZipStream;

  class S3ObjectsStreamZip
  {
    
    protected $auth = array();
    
    protected $s3Client;

    public function __construct($auth)
    {
      $this->authValidation($auth);

      $this->s3Client();
    }

    public function sendObjects($bucket, $files, $zipname)
    {

      $this->paramsValidation(array("bucket" => $bucket, "files" => $files, "zipname" => $zipname));

      $zip = new ZipStream($zipname);

      foreach ($files as $file) {

        $fileName = isset($file['name']) ? $file['name'] : basename($file['path']);

        $context = stream_context_create(array(
          's3' => array('seekable' => true)
        ));
        
        $fileURLS3 = "s3://{$bucket}/{$file['path']}";
        
        // https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html#downloading-data
        if ($stream = fopen($fileURLS3, 'r', false, $context)) {
          $zip->addFileFromStream($fileName, $stream);
        }

      }

      $zip->finish();
    }

    protected function authValidation($auth)
    {
      if (!isset($auth['version'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `version` attribute.');
      }

      if (!isset($auth['region'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `region` attribute.');
      }

      if (!isset($auth['credentials'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `credentials` attribute.');
      }

      if (!isset($auth['credentials']['key'])) {
        throw new InvalidParamsException('$auth["credentials"] parameter to constructor requires a `key` attribute.');
      }

      if (!isset($auth['credentials']['secret'])) {
        throw new InvalidParamsException('$auth["credentials"] parameter to constructor requires a `secret` attribute.');
      }

      $this->auth = $auth;
    }

    protected function s3Client()
    {
      $s3Client = new S3Client(array(
        'version' => $this->auth['version'],
        'region' => $this->auth['region'],
        'credentials' => array(
          'key' => $this->auth['credentials']['key'],
          'secret' => $this->auth['credentials']['secret']
        )
      ));
      $this->s3Client = $s3Client;
      $this->s3Client->registerStreamWrapper();
    }

    protected function paramsValidation($params) {
      
      // bucket
      if (!isset($params["bucket"])) {
        throw new InvalidParamsException('The parameter `bucket` is required.');
      }
      else if (empty($params["bucket"])) {
        throw new InvalidParamsException('The parameter `bucket` cannot be an empty string.');
      } 
      else {
        $this->doesBucketExists($params["bucket"]);
      }

      // files
      if (!isset($params["files"])) {
        throw new InvalidParamsException('The parameter `files` is required.');
      }
      else if (!is_array($params["files"])) {
        throw new InvalidParamsException('The parameter `files` must be an array.');
      }
      else if (empty($params["files"])) {
        throw new InvalidParamsException('The parameter `files` cannot be an empty array.');
      }
      else if (!is_array(current($params["files"]))) {
        throw new InvalidParamsException('The array `files` requires a `path` attribute.');
      }
      else {
        $this->objectsValidation($params["files"]);
      }

      // zipname
      if (!isset($params["zipname"])) {
        throw new InvalidParamsException('The parameter `zipname` is required.');
      }
      else if (empty($params["zipname"])) {
        throw new InvalidParamsException('The parameter `zipname` cannot be an empty string.');
      }
      
    }

    protected function objectsValidation($files)
    {
      foreach ($files as $file) {
        if (!array_key_exists('path', $file)) {
          throw new InvalidParamsException('The array `files` requires an nested array with `path` attribute.');
        }
        else if (empty($file['path'])) {
          throw new InvalidParamsException('The `path` cannot be an empty string.');
        }
        else {
          // https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html#other-object-functions
          $fileURLS3 = "s3://{$params['bucket']}/{$file['path']}";
          if (!file_exists($fileURLS3)) {
            throw new InvalidParamsException("The file `{$file['path']}` you have requested does not exist.");
          }
          else if (!is_file($fileURLS3)) {
            throw new InvalidParamsException("The action cannot be completed because `{$file['path']}` it's not a file.");
          }
        }
      }
    }

    protected function doesBucketExists($bucket) {
      try {
        // http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#headbucket
        $this->s3Client->headBucket(array(
          'Bucket' => $bucket
        ));  
      } 
      catch (S3Exception $e) {
        throw new InvalidParamsException("Bucket `{$bucket}` does not exists and/or you have not permission to access it.");
      }
    }
}

?>