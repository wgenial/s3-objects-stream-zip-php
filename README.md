# S3ObjectsStreamZip

[![Packagist](https://img.shields.io/packagist/v/wgenial/s3-objects-stream-zip-php.svg)](https://packagist.org/packages/wgenial/s3-objects-stream-zip-php)
[![GitHub license](https://img.shields.io/github/license/wgenial/s3-objects-stream-zip-php.svg)](https://github.com/wgenial/s3-objects-stream-zip-php/blob/master/LICENSE)


## Overview
S3ObjectsStreamZip is a PHP library to stream objects from AWS S3 as a zip file.

Uses AWS SDK Version 3 to [stream objects directly from S3](https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html).


## Install
```
composer require wgenial/s3-objects-stream-zip-php
```

## Usage
See [example](https://github.com/wgenial/s3-objects-stream-zip-php/blob/master/example/index.php) folder.


## Dependencies
* ```aws/aws-sdk-php```
* ```maennchen/zipstream-php```


## Authors
* [@giovanigenerali](https://github.com/giovanigenerali)
* [@wgenial](https://github.com/wgenial)