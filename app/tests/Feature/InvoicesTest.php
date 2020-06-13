<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoicesTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function not_authenticated_user_cant_create_a_new_invoice()
    {
        $this->withoutExceptionHandling([AuthenticationException::class]);

        $this->get('invoices/new')
            ->assertRedirect('login');
    }

    /** @test */

    public function customer_can_see_a_form_for_creating_new_invoice()
    {
        $this->withoutExceptionHandling();
        $user= factory(User::class)->create();

        $this->actingAs($user)->get('invoices/new')
            ->assertStatus(200)
            ->assertSee('Create new Invoice');
    }
}
