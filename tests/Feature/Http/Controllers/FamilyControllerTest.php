<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Tests\Feature\Http\Controllers;

use App\ClientUser;
use App\Family;
use App\StaffUser;
use App\Student;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FamilyControllerTest extends TestCase
{
    use RefreshDatabase;


    function getFakeParent(array $attributes = []): array
    {
        return array_merge([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'j.doe@webmail.test',
            'wechat_id' => 'jdoe',
            'phone' => '0122334455',
            'address' => '525 Main street, 88955 Fake City',
        ], $attributes);
    }


    function getFakeStudent(array $attributes = []): array
    {
        return array_merge([
            'firstname' => 'John Junior',
            'lastname' => 'Doe',
            'birthday' => '2006-05-19',
            'notes' => 'Nothing special about him.',
        ], $attributes);
    }


    /**+
     * When a family is created, the user is redirected to the page
     * of the newly created family.
     *
     * @return void
     */
    public function testCreateFamilyAndRedirect()
    {
        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->post(route('families.store'), [
                'parent' => $this->getFakeParent(),
                'student' => $this->getFakeStudent(),
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, Family::count());
        $this->assertEquals(1, Student::count());
        $this->assertEquals(1, ClientUser::count());

        $family = Family::first();

        $this->assertCount(1, $family->students);
        $this->assertCount(1, $family->parents);

        $response->assertRedirect(route('families.show', $family));
    }


    /**
     * When creating family, if the parent already exists without belonging to
     * an existing family, a new family is created to the existing parent.
     *
     * @return void
     */
    public function testCreateFamilyWithoutParentDuplicates()
    {
        /** @var ClientUser $parent */
        factory(ClientUser::class)->create($this->getFakeParent());

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->post(route('families.store'), [
                'parent' => $this->getFakeParent(),
                'student' => $this->getFakeStudent(),
            ]);

        $this->assertEquals(1, ClientUser::count());
        $response->assertRedirect(route('families.show', Family::first()));
    }


    /**
     * When creating family, if the parent already exists and belongs to
     * an existing family, the new student is just link to the existing family.
     *
     * @return void
     */
    public function testCreateFamilyWithoutFamilyDuplicates()
    {
        /** @var ClientUser $parent */
        $parent = factory(ClientUser::class)->create($this->getFakeParent());

        $family = Family::create();
        $parent->family()->associate($family);
        $parent->save();

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->post(route('families.store'), [
                'parent' => $this->getFakeParent(),
                'student' => $this->getFakeStudent(),
            ]);

        $this->assertEquals(1, Family::count());
        $response->assertRedirect(route('families.show', Family::first()));
    }
}
