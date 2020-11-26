<?php
namespace Library\Helper\Google;
use Google_Service_CloudKMS as Kms;
use Google_Service_CloudKMS_DecryptRequest as DecryptRequest;
use Google_Service_CloudKMS_EncryptRequest as EncryptRequest;

class KeyManagerHelper {


    // Properties
    private $kms;
    private $encryptRequest;
    private $decryptRequest;
    private $projectId;
    private $locationId;
    private $keyRingId;
    private $cryptoKeyId;

    private $kmsConfig = JSON_CONFIG . 'HRMS-Markaxis-75b213b4b0d5.json';
    private $kmsScope = 'https://www.googleapis.com/auth/cloud-platform';


    public function __construct( ) {
        require( ROOT . './Library/vendor/autoload.php' );
        $this->encryptRequest = new EncryptRequest( );
        $this->decryptRequest = new DecryptRequest( );

        try {
            $client = new \Google_Client( );
            $client->setAuthConfig( $this->kmsConfig );
            $client->addScope( $this->kmsScope );

            $jsonData = json_decode( file_get_contents( $this->kmsConfig ),true );

            $this->kms = new Kms( $client );
            $this->projectId   = $jsonData['projectId'];
            $this->locationId  = $jsonData['locationId'];
            $this->keyRingId   = $jsonData['keyRingId'];
            $this->cryptoKeyId = $jsonData['cryptoKeyId'];
        }
        catch( \Exception $e ) {
            die($e->getCode());
        }
    }


    public function encrypt( $data ) {
        try {
            $key        = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES ) ;
            $nonce      = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );
            $ciphertext = sodium_crypto_secretbox( $data, $nonce, $key );

            return [
                'data'   => base64_encode($nonce . $ciphertext ),
                'secret' => $this->encryptKey( $key ),
            ];
        }
        catch( \Exception $e ) {
            die( $e );
        }
    }


    public function decrypt( $secret, $data ) {
        $decoded    = base64_decode( $data );
        $key        = $this->decryptSecret( $secret );
        $nonce      = mb_substr( $decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit' );
        $ciphertext = mb_substr( $decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit' );

        return sodium_crypto_secretbox_open( $ciphertext, $nonce, $key );
    }


    private function encryptKey( $key ) {
        $this->encryptRequest->setPlaintext( base64_encode( $key ) );

        $response = $this->kms->projects_locations_keyRings_cryptoKeys->encrypt(
            $this->getResourceName( ),
            $this->encryptRequest
        );

        return $response['ciphertext'];
    }


    private function decryptSecret( $secret ) {
        $this->decryptRequest->setCiphertext( $secret );

        $response = $this->kms->projects_locations_keyRings_cryptoKeys->decrypt(
            $this->getResourceName( ),
            $this->decryptRequest
        );

        return base64_decode( $response['plaintext'] );
    }


    private function getResourceName( ) {
        return sprintf(
            'projects/%s/locations/%s/keyRings/%s/cryptoKeys/%s',
            $this->projectId,
            $this->locationId,
            $this->keyRingId,
            $this->cryptoKeyId
        );
    }
}