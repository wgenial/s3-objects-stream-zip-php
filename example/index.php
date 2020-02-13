<?php
  include __DIR__.'/../vendor/autoload.php';

  use Aws\S3\Exception\S3Exception;
  use WGenial\S3ObjectsStreamZip\S3ObjectsStreamZip;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;

  try {
    // http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/credentials.html#hardcoded-credentials
    $zipStream = new S3ObjectsStreamZip(array(
      'version' => 'latest', // https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_configuration.html#version
      'region' => 'your-aws-bucket-region', // https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_configuration.html#region
      'credentials' => array(
        'key'    => 'your-aws-key',
        'secret' => 'your-aws-secret'
      ),
      // 'endpoint' => '', // https://docs.aws.amazon.com/general/latest/gr/s3.html
      // 'bucket_endpoint' => '', // https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html#___construct
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
