<?php
  set_time_limit(0);
  // date_default_timezone_set('America/Sao_Paulo');

  include __DIR__.'/../vendor/autoload.php';
  
  use Aws\S3\Exception\S3Exception;
  use WGenial\S3ObjectsStreamZip\S3ObjectsStreamZip;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;

  try {
    // http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/credentials.html#hardcoded-credentials
    $zipStream = new S3ObjectsStreamZip(array(
      'version' => 'latest', // http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html#version
      'region' => 'your-aws-bucket-region', // http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html#region
      'credentials' => array(
        'key'    => 'your-aws-key',
        'secret' => 'your-aws-secret'
      )
    ));

    $bucket = 'your-s3-bucket'; // required
    $objects = array(
      array(
        'path' => 'file-text.txt' // required
      ),
      array(
        'name' => 'file-pdf.pdf', // not required
        'path' => 'file-pdf.pdf' // required
      ),
      array(
        'path' => 'logs/file-log.txt' // required
      ),
      array(
        'name' => 'image.png', // you can rename an object to zip, not required
        'path' => 'file-image.png' // required
      )
    );

    $zipname = 'compress.zip'; // required

    $checkObjectExist = false; // no required | default = false
    
    $zipStream->zipObjects($bucket, $objects, $zipname, $checkObjectExist);
  } 
  catch (InvalidParamsException $e) {
    echo $e->getMessage();
  } 
  catch (S3Exception $e) {
    echo $e->getMessage();
  }
