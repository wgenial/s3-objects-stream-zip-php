# S3ObjectsStreamZip

[![Packagist](https://img.shields.io/packagist/v/wgenial/s3-objects-stream-zip-php.svg)](https://packagist.org/packages/wgenial/s3-objects-stream-zip-php)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/719df2ec6ebf460e85bb2192f82758b7)](https://www.codacy.com/app/giovanigenerali/s3-objects-stream-zip-php?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=wgenial/s3-objects-stream-zip-php&amp;utm_campaign=Badge_Grade)
[![Build Status](https://travis-ci.org/wgenial/s3-objects-stream-zip-php.svg?branch=master)](https://travis-ci.org/wgenial/s3-objects-stream-zip-php)
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
* ```guzzlehttp/guzzle```

## Authors
* [@giovanigenerali](https://github.com/giovanigenerali)
* [@wgenial](https://github.com/wgenial)


## Contributors
* [@sjoerdstaal](https://github.com/sjoerdstaal)
* [@florianv](https://github.com/florianv)
* [@marcelod](https://github.com/marcelod)
