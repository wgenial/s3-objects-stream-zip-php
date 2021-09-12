# S3ObjectsStreamZip

[![Packagist](https://img.shields.io/packagist/v/wgenial/s3-objects-stream-zip-php?style=for-the-badge)](https://packagist.org/packages/wgenial/s3-objects-stream-zip-php)
[![PHP Version](https://img.shields.io/packagist/php-v/wgenial/s3-objects-stream-zip-php?style=for-the-badge)](https://github.com/wgenial/s3-objects-stream-zip-php/blob/master/composer.json#L18)
[![Codacy](https://img.shields.io/codacy/grade/564e1f208bab4916bad61cdacbca450a?style=for-the-badge)](https://app.codacy.com/gh/wgenial/s3-objects-stream-zip-php)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/wgenial/s3-objects-stream-zip-php/Test?label=test&logo=github&style=for-the-badge)](https://github.com/wgenial/s3-objects-stream-zip-php/actions?query=workflow%3ATest)
[![Travis](https://img.shields.io/travis/wgenial/s3-objects-stream-zip-php?style=for-the-badge&label=travis)](https://app.travis-ci.com/wgenial/s3-objects-stream-zip-php)
[![License](https://img.shields.io/packagist/l/wgenial/s3-objects-stream-zip-php?style=for-the-badge)](https://github.com/wgenial/s3-objects-stream-zip-php/blob/master/LICENSE)

## Overview

S3ObjectsStreamZip is a PHP library to stream objects from AWS S3 as a zip file.

Uses AWS SDK Version 3 to [stream objects directly from S3](https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html).

## Install

```
composer require wgenial/s3-objects-stream-zip-php
```

## Usage

See [example](https://github.com/wgenial/s3-objects-stream-zip-php/blob/master/example/index.php) folder.

```php
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
```

## Dependencies

- `aws/aws-sdk-php`
- `maennchen/zipstream-php`
- `guzzlehttp/guzzle`

## Author

- [@giovanigenerali](https://github.com/giovanigenerali)

## Contributors

- [@sjoerdstaal](https://github.com/sjoerdstaal)
- [@florianv](https://github.com/florianv)
- [@marcelod](https://github.com/marcelod)
