<?php

namespace Controllers;

use \Bulletproof\Image;
use \Models\Database;

class Customer
{
    const PICTURE_PATH = __DIR__ . "/../../assets/images/";
    const MIN_SIZE = 1000;
    const MAX_SIZE = 600000;
    private $customerTable;

    public function __construct(Database $customerTable)
    {

        $this->customerTable = $customerTable;
    }

    public function home()
    {
        $title = 'ABUKAI ENGINEERING PROJECT EXERCISE/TEST';
        return ['template' => 'home.php', 'title' => $title];
    }

    public function review()
    {

        if (isset($_GET['email'])) {
            $customer = $this->customerTable->find('email', $_GET['email']);
        }

        $title = 'Customer Information Review';
        return ['template' => 'review.php', 'title' => $title, 'variables' => [
            'customer' => $customer ?? ''
        ]];
    }

    private function isImageFileSizeValid($image, $minImageSize, $maxImageSize): bool
    {
        return (filesize($image) > $minImageSize) && (filesize($image) < $maxImageSize);
    }

    private function getRandomString(int $length = 7, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    private function handleImageUpload(\Bulletproof\Image $image): string
    {

        // define the min/max image upload size (size in bytes) 
        $min = self::MIN_SIZE;
        $max = self::MAX_SIZE;

        //check if image is a valid image file
        if (!is_file($_FILES['picture']['tmp_name'])) {
            throw new \Exception('invalid image');
        }

        // check upload size
        $isImageSizeValid = $this->isImageFileSizeValid($_FILES['picture']["tmp_name"], $min, $max);
        if (!$isImageSizeValid) {
            throw new \Exception("image size must be between " . ($min / 1000) . "kb and " . ($max / 1000) . "kb");
        }

        // define allowed mime types to upload,min/max image upload size (size in bytes)
        $image->setMime(array('jpeg', 'png', 'jpg'))->setStorage(self::PICTURE_PATH)->setSize($min, $max);

        $filename = pathinfo($_FILES['picture']['name'], PATHINFO_FILENAME);
        $filename = $filename . "" . $this->getRandomString();
        $image->setName($filename);

        if ($image->upload()) {
            $photo = $image->getName() . '.' . $image->getMime();
            $imageUploadPath = "app/assets/images/" . $photo;
            $imageUrl =  SITE_HOST . "/" . TOP_LEVEL_PATH . $imageUploadPath;

            return $imageUrl;
        } else {

            throw new \Exception(" Please upload the recommended image type");
        }
    }

    private function validateFormInputs($formData)
    {
        // Define a regular expression pattern to match a non-empty string
        $pattern = "/^.+$/";

        $errors = [];
        foreach ($formData as $key  => $value) {

            if (!filter_var($value, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $pattern)))) {
                $errors[$key] = "Invalid " . $key;
            }

            if ($key == 'email' && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                $errors[$key] = "Invalid " . $key;
            }
        }

        return $errors;
    }

    public function registerCustomer()
    {
        $formData = $_POST;
        $isValid = true;
        $errors = [];

        //validate form fields
        $errorExist = $this->validateFormInputs($formData);
        if ($errorExist) {
            $isValid = false;
            $errors  = $errorExist;
        }

        //check if customer email exist in database
        //convert the email to lowercase
        $formData['email'] = strtolower($formData['email']);
        //search for the lowercase version of the user email in database
        if (count($this->customerTable->find('email', $formData['email'])) > 0) {
            $isValid  = false;
            $errors['email'] = 'email address is already registered';
        }

        // check if all form input is valid before uploading image
        if ($isValid && !empty($_FILES['picture'])) {
            $image = new \Bulletproof\Image($_FILES);
            if ($image["picture"]) {
                try {
                    $formData['picture'] = $this->handleImageUpload($image);
                } catch (\Exception $e) {
                    $isValid = false;
                    $errors['picture'] = $e->getMessage();
                }
            } else {
                $isValid = false;
                $errors['picture'] = 'Invalid Image';
            }
        }


        if ($isValid) {
            try {
                $customer = $this->customerTable->save($formData);
                return [
                    'data' => [
                        "message" => "customer updated successfully",
                        "customer" => $customer,
                    ],
                    'status_code' => 201
                ];
            } catch (\Exception $e) {
                $errors['unexpected'] = 'An unexpected error occured! ' . $e->getMessage();
                return [
                    'data' => [
                        "errors" => $errors
                    ],
                    'status_code' => 500
                ];
            }
        }

        return [
            'data' => [
                "errors" => $errors
            ],
            'status_code' => 400
        ];
    }
}
