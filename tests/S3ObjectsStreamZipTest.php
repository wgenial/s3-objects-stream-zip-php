<?php
  namespace WGenial\S3ObjectsStreamZipTest;

  use WGenial\S3ObjectsStreamZip\S3ObjectsStreamZip;
  use WGenial\S3ObjectsStreamZip\Exception;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;

  class S3ObjectsStreamZipTest extends \PHPUnit\Framework\TestCase
  {

    public function testInvalidParams()
    {
      try {
        new S3ObjectsStreamZip(array());
      } catch (Exception $e) {
        $this->assertEquals('$auth parameter to constructor requires a `version` attribute.', $e->getMessage());
      }
    }

    public function testInvalidVersionParam()
    {
      try {
        new S3ObjectsStreamZip(array(
          'version' => ''
        ));
      } catch (Exception $e) {
        $this->assertEquals('$auth parameter to constructor requires a `version` attribute.', $e->getMessage());
      }
    }

    public function testInvalidRegionParam()
    {
      try {
        new S3ObjectsStreamZip(array(
          'version' => 'latest',
          'region' => ''
        ));
      } catch (Exception $e) {
        $this->assertEquals('$auth parameter to constructor requires a `region` attribute.', $e->getMessage());
      }
    }

    public function testInvalidCredentialsParam()
    {
      try {
        new S3ObjectsStreamZip(array(
          'version' => 'latest',
          'region' => 'us-east-1',
          'credentials' => array(
          )
        ));
      } catch (Exception $e) {
        $this->assertEquals('$auth parameter to constructor requires a `credentials` attribute.', $e->getMessage());
      }
    }

    public function testInvalidCredentialsKeyParam()
    {
      try {
        new S3ObjectsStreamZip(array(
          'version' => 'latest',
          'region' => 'us-east-1',
          'credentials' => array(
            'key' => ''
          )
        ));
      } catch (Exception $e) {
        $this->assertEquals('$auth["credentials"] parameter to constructor requires a `key` attribute.', $e->getMessage());
      }
    }

    public function testInvalidCredentialsSecretParam()
    {
      try {
        new S3ObjectsStreamZip(array(
          'version' => 'latest',
          'region' => 'us-east-1',
          'credentials' => array(
            'key' => 'aws-key',
            'secret' => ''
          )
        ));
      } catch (Exception $e) {
        $this->assertEquals('$auth["credentials"] parameter to constructor requires a `secret` attribute.', $e->getMessage());
      }
    }

    public function testeInvalidParamsToZipObjects()
    {
      try {
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
      } catch (Exception $e) {
        $this->assertEquals('The parameter `bucket` cannot be an empty string.', $e->getMessage());
      }
    }

    public function testeInvalidObjectsArrayEmptyNameAttributeToZipObjects()
    {
      try {
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
      } catch (Exception $e) {
        $this->assertEquals('Bucket `my-bucket` does not exists and/or you have not permission to access it.', $e->getMessage());
      }
    }

    public function testeInvalidObjectsArrayEmptyPathAttributeToZipObjects()
    {
      try {
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
      } catch (Exception $e) {
        $this->assertEquals('Bucket `my-bucket` does not exists and/or you have not permission to access it.', $e->getMessage());
      }
    }

    public function testeInvalidObjectsArrayEmptyToZipObjects()
    {
      try {
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
      } catch (Exception $e) {
        $this->assertEquals('Bucket `my-bucket` does not exists and/or you have not permission to access it.', $e->getMessage());
      }
    }

    public function testeInvalidZipnameParamToZipObjects()
    {
      try {
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

        $zipStream->zipObjects($bucket, $objects, $zipname);
      } catch (Exception $e) {
        $this->assertEquals('Bucket `my-bucket` does not exists and/or you have not permission to access it.', $e->getMessage());
      }
    }

  }