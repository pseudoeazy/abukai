<?php

use \PHPUnit\Framework\TestCase;
use \Controllers\Customer;
use \Models\Database;

class CustomerTest extends TestCase
{
    const formData = [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'email' => 'john@doe.com',
        'city' => 'New York',
        'country' => 'United States'
    ];

    private $customer;
    private $customerTableMock;


    public function setUp(): void
    {
        $this->customerTableMock = $this->createMock(Database::class);
        $this->customer = new Customer($this->customerTableMock);
    }


    public function testHomeMethod()
    {
        $result = $this->customer->home();

        // Expected template and title
        $expectedTemplate = 'home.php';
        $expectedTitle = 'ABUKAI ENGINEERING PROJECT EXERCISE/TEST';

        // Assertions on the result
        $this->assertArrayHasKey('template', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertEquals($expectedTemplate, $result['template']);
        $this->assertEquals($expectedTitle, $result['title']);
    }

    public function testPrivateMethodValidateFormInputs()
    {
        $reflectionClass = new \ReflectionClass($this->customer);
        $validateFormInputs = $reflectionClass->getMethod("validateFormInputs");
        $validateFormInputs->setAccessible(true);

        // Simulate Submitted Form Data
        $formDataWithError = [
            'firstname' => '',
            'lastname' => 'Doe',
            'email' => 'johndoe.com',
            'city' => 'New York',
            'country' => 'United States'
        ];

        // Expected errors
        $resultWithNoError = count($validateFormInputs->invoke($this->customer, self::formData));
        $resultForError = count($validateFormInputs->invoke($this->customer, $formDataWithError));

        //Assertions on the result
        $this->assertEquals(0, $resultWithNoError);
        $this->assertEquals(2, $resultForError);
    }

    public function testReviewMethodWithEmail()
    {
        // Set up the mock behavior for find method
        $customerData = ['id' => 1, 'name' => 'John Doe'];

        $this->customerTableMock->method('find')
            ->with('email', 'john@doe.com')
            ->willReturn($customerData);

        // Simulate $_GET['email'] being set
        $_GET['email'] = 'john@doe.com';

        $result = $this->customer->review();

        // Expected template and title
        $expectedTemplate = 'review.php';
        $expectedTitle = 'Customer Information Review';

        // Assertions on the result
        $this->assertArrayHasKey('template', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('variables', $result);
        $this->assertEquals($expectedTemplate, $result['template']);
        $this->assertEquals($expectedTitle, $result['title']);
        $this->assertEquals($customerData, $result['variables']['customer']);
    }

    public function testReviewMethodWithoutEmail()
    {

        // Simulate $_GET['email'] not being set
        unset($_GET['email']);

        // Call the review method
        $result = $this->customer->review();

        // Expected template and title
        $expectedTemplate = 'review.php';
        $expectedTitle = 'Customer Information Review';

        // Assertions on the result
        $this->assertArrayHasKey('template', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('variables', $result);
        $this->assertEquals($expectedTemplate, $result['template']);
        $this->assertEquals($expectedTitle, $result['title']);
        $this->assertEquals('', $result['variables']['customer']);
    }



    public function testRegisterCustomerWithValidData()
    {
        // Set up mock behavior for find and save methods
        $this->customerTableMock->method('find')
            ->willReturn([]); // Simulate email not found
        $this->customerTableMock->method('save')
            ->willReturn(['id' => 123]); // Simulate successful save


        // Simulate valid form data
        $_POST = self::formData;

        // Call the registerCustomer method
        $result = $this->customer->registerCustomer();


        // Expected result for successful registration
        $expectedResult = [
            'data' => [
                'message' => 'customer updated successfully',
                'customer' => ['id' => 123]
            ],
            'status_code' => 201
        ];

        // Assertions on the result
        $this->assertEquals($expectedResult, $result);
    }

    public function testRegisterCustomerWithExistingEmail()
    {
        // Set up mock behavior for find method to simulate email found
        $this->customerTableMock->method('find')
            ->willReturn(['id' => 456]);


        // Simulate form data with existing email
        $_POST = self::formData;

        // Call the registerCustomer method
        $result = $this->customer->registerCustomer();

        // Expected result for existing email
        $expectedResult = [
            'data' => [
                'errors' => ['email' => 'email address is already registered']
            ],
            'status_code' => 400
        ];

        // Assertions on the result
        $this->assertEquals($expectedResult, $result);
    }
}
