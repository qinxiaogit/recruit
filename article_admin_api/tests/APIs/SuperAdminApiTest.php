<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SuperAdmin;

class SuperAdminApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/super_admins', $superAdmin
        );

        $this->assertApiResponse($superAdmin);
    }

    /**
     * @test
     */
    public function test_read_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/super_admins/'.$superAdmin->id
        );

        $this->assertApiResponse($superAdmin->toArray());
    }

    /**
     * @test
     */
    public function test_update_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();
        $editedSuperAdmin = factory(SuperAdmin::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/super_admins/'.$superAdmin->id,
            $editedSuperAdmin
        );

        $this->assertApiResponse($editedSuperAdmin);
    }

    /**
     * @test
     */
    public function test_delete_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/super_admins/'.$superAdmin->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/super_admins/'.$superAdmin->id
        );

        $this->response->assertStatus(404);
    }
}
