<?php
  namespace WGenial\S3ObjectsStreamZipTest;

  use WGenial\S3ObjectsStreamZip\S3ObjectsStreamZip;
  use WGenial\S3ObjectsStreamZip\Exception;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;

  class S3ObjectsStreamZipTest extends \PHPUnit\Framework\TestCase
  {

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidParams()
    {
      new S3ObjectsStreamZip(array(
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidVersionParam()
    {
      new S3ObjectsStreamZip(array(
        'version' => ''
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidRegionParam()
    {
      new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => ''
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidCredentialsParam()
    {
      new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
        )
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidCredentialsKeyParam()
    {
      new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => ''
        )
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testInvalidCredentialsSecretParam()
    {
      new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => ''
        )
      ));
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testeInvalidParamsToZipObjects()
    {
      $zipStream = new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => 'aws-secret'
        )
      ));

      $bucket = '';
      $objects = array();
      $zipname = '';

      $zipStream->zipObjects($bucket, $objects, $zipname);
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testeInvalidObjectsArrayEmptyNameAttributeToZipObjects()
    {
      $zipStream = new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => 'aws-secret'
        )
      ));

      $bucket = 'my-bucket';
      $objects = array(
        array(
          'name' => '',
          'path' => 'file.txt'
        )
      );
      $zipname = 'zipfile';

      $zipStream->zipObjects($bucket, $objects, $zipname);
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testeInvalidObjectsArrayEmptyPathAttributeToZipObjects()
    {
      $zipStream = new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => 'aws-secret'
        )
      ));

      $bucket = 'my-bucket';
      $objects = array(
        array(
          'path' => ''
        )
      );
      $zipname = 'zipfile';

      $zipStream->zipObjects($bucket, $objects, $zipname);
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testeInvalidObjectsArrayEmptyToZipObjects()
    {
      $zipStream = new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => 'aws-secret'
        )
      ));

      $bucket = 'my-bucket';
      $objects = array(
        array()
      );
      $zipname = 'zipfile';

      $zipStream->zipObjects($bucket, $objects, $zipname);
    }

    /**
    * @expectedException \WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException
    */
    public function testeInvalidZipnameParamToZipObjects()
    {
      $zipStream = new S3ObjectsStreamZip(array(
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => array(
          'key' => 'aws-key',
          'secret' => 'aws-secret'
        )
      ));

      $bucket = 'my-bucket';
      $objects = array(
        array(
          'name' => 'text.txt',
          'path' => 'file.txt'
        )
      );
      $zipname = '';

      $zipStream->zipObjects($bucket, $object, $zipname);
    }

  }