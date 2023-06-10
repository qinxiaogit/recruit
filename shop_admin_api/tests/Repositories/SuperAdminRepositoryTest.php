<?php namespace Tests\Repositories;

use App\Models\SuperAdmin;
use App\Repositories\SuperAdminRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SuperAdminRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SuperAdminRepository
     */
    protected $superAdminRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->superAdminRepo = \App::make(SuperAdminRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->make()->toArray();

        $createdSuperAdmin = $this->superAdminRepo->create($superAdmin);

        $createdSuperAdmin = $createdSuperAdmin->toArray();
        $this->assertArrayHasKey('id', $createdSuperAdmin);
        $this->assertNotNull($createdSuperAdmin['id'], 'Created SuperAdmin must have id specified');
        $this->assertNotNull(SuperAdmin::find($createdSuperAdmin['id']), 'SuperAdmin with given id must be in DB');
        $this->assertModelData($superAdmin, $createdSuperAdmin);
    }

    /**
     * @test read
     */
    public function test_read_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();

        $dbSuperAdmin = $this->superAdminRepo->find($superAdmin->id);

        $dbSuperAdmin = $dbSuperAdmin->toArray();
        $this->assertModelData($superAdmin->toArray(), $dbSuperAdmin);
    }

    /**
     * @test update
     */
    public function test_update_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();
        $fakeSuperAdmin = factory(SuperAdmin::class)->make()->toArray();

        $updatedSuperAdmin = $this->superAdminRepo->update($fakeSuperAdmin, $superAdmin->id);

        $this->assertModelData($fakeSuperAdmin, $updatedSuperAdmin->toArray());
        $dbSuperAdmin = $this->superAdminRepo->find($superAdmin->id);
        $this->assertModelData($fakeSuperAdmin, $dbSuperAdmin->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_super_admin()
    {
        $superAdmin = factory(SuperAdmin::class)->create();

        $resp = $this->superAdminRepo->delete($superAdmin->id);

        $this->assertTrue($resp);
        $this->assertNull(SuperAdmin::find($superAdmin->id), 'SuperAdmin should not exist in DB');
    }
}
