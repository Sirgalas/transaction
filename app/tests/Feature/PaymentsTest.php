<?php

namespace Tests\Feature;

use App\Entities\Payments\FakePaymentCodeGenerator;
use App\Entities\Payments\Interfaces\PaymentCodeGeneratorInterface;
use App\Entities\PaymentStatus;
use App\Entities\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Entities\Payment;
use Illuminate\Validation\ValidationException;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function not_authenticated_user_cant_create_a_new_payment()
    {
        $this->withoutExceptionHandling([AuthenticationException::class]);

        $this->get('payments/new')
            ->assertRedirect('login');
    }

    /** @test */

    public function customer_can_see_a_form_for_creating_new_payment()
    {
        $this->withoutExceptionHandling();
        $user= factory(User::class)->create();

        $this->actingAs($user)->get('payments/new')
            ->assertStatus(200)
            ->assertSee('Create new Invoice');
    }

    /** @test */
    public function user_not_can_create_a_new_payment()
    {
        $response=$this->json('post','payments',[
            'email'=>'hudosg@gmail.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>'Sergalas',
            'description'=>'Payment',
            'message'=>'hello',
        ]);
        $response->assertStatus(401);
        $this->assertEquals(0, Payment::count());
    }

    /** @test */
    public function user_can_create_a_new_payment()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $fakePaymentCodeGenerator= new FakePaymentCodeGenerator();
        $this->app->instance(PaymentCodeGeneratorInterface::class,$fakePaymentCodeGenerator);


        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(1, Payment::count());
        tap(Payment::first(),function (Payment $payment)use($user)
            {
               $payment->code=(new FakePaymentCodeGenerator())->generate();
               $this->assertEquals($user->id,$payment->user_id);
               $this->assertEquals('test@test.com',$payment->email);
               $this->assertEquals(5000,$payment->amount);
               $this->assertEquals('usd',$payment->currency);
               $this->assertEquals('User',$payment->name);
               $this->assertEquals('Description',$payment->description);
               $this->assertEquals('hello',$payment->message);
               $this->assertEquals('TESTCODE123456',$payment->code);
               $this->assertEquals(PaymentStatus::NEW,$payment->status_id);
            }
        );
    }
    /**
     * @test
     *  ValidationException
     */
    public function create_a_new_payment_not_email()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            //'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);
        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('email');

    }
    /** @test */
    public function create_a_new_payment_not_valid_email()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'testtestcom',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);
        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('email');

    }

    /** @test */
    public function create_a_new_payment_not_amount()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            //'amount'=>5000,
            'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('amount');
    }
    /** @test */
    public function create_a_new_payment_not_valid_amount()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>'aa',
            'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('amount');
    }

    /** @test */
    public function create_a_new_payment_not_not_currency()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            //'currency'=>'usd',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('currency');
    }
    /** @test */
    public function create_a_new_payment_not_valid_big_currency()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usds',
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('currency');
    }
    /** @test
     *
     */
    public function create_a_new_payment_not_valid_currency()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>1,
            'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('currency');
    }
    /** @test */
    public function create_a_new_payment_not_name()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            //'name'=>'User',
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('name');
    }
    /** @test */
    public function create_a_new_payment_not_valid_name()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>1,
            'description'=>'Description',
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('name');
    }
    /** @test */
    public function create_a_new_payment_not_valid_description()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>1,
            'description'=>1,
            'message'=>'hello',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('name');
    }
    /** @test */
    public function create_a_new_payment_not_valid_message()
    {

        $user = factory(User::class)->create();
        /** @var $user User */
        $response=$this->actingAs($user)->json('post','payments',[
            'email'=>'test@test.com',
            'amount'=>5000,
            'currency'=>'usd',
            'name'=>1,
            'description'=>'description',
            'message'=>1,
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Payment::count());
        $response->assertJsonValidationErrors('name');
    }
}
