<?php

namespace App\DataFixtures;

use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{

    private $counter = 1;
    public function __construct(private SluggerInterface $slugger){

    }
    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategories('Informatique',null,$manager);


        $this->createCategories('Ordinateurs',$parent,$manager);
        $this->createCategories('Ecran',$parent,$manager);
        $this->createCategories('Souris',$parent,$manager);


        $manager->flush();
    }


    public function createCategories(string $name, Categories $parent = null, ObjectManager $manager){
        $categories = new Categories;
        $categories->setName($name);
        $categories->setSlug($this->slugger->slug($categories->getName())->lower());
        $categories->setParent($parent);
        $manager->persist($categories);

        $this->addReference('cat-'.$this->counter,$categories);

        $this->counter++;

        return $categories;
    }
}
