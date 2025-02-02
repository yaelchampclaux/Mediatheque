<?php

namespace App\Tests\Controller;

use App\Entity\Oeuvre;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class OeuvreControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $oeuvreRepository;
    private string $path = '/oeuvre/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->oeuvreRepository = $this->manager->getRepository(Oeuvre::class);

        foreach ($this->oeuvreRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Oeuvre index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'oeuvre[titre]' => 'Testing',
            'oeuvre[photo]' => 'Testing',
            'oeuvre[annee]' => 'Testing',
            'oeuvre[auteurs]' => 'Testing',
            'oeuvre[editions]' => 'Testing',
            'oeuvre[type]' => 'Testing',
            'oeuvre[serie]' => 'Testing',
            'oeuvre[Lieu]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->oeuvreRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Oeuvre();
        $fixture->setTitre('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setAnnee('My Title');
        $fixture->setAuteurs('My Title');
        $fixture->setEditions('My Title');
        $fixture->setType('My Title');
        $fixture->setSerie('My Title');
        $fixture->setLieu('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Oeuvre');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Oeuvre();
        $fixture->setTitre('Value');
        $fixture->setPhoto('Value');
        $fixture->setAnnee('Value');
        $fixture->setAuteurs('Value');
        $fixture->setEditions('Value');
        $fixture->setType('Value');
        $fixture->setSerie('Value');
        $fixture->setLieu('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'oeuvre[titre]' => 'Something New',
            'oeuvre[photo]' => 'Something New',
            'oeuvre[annee]' => 'Something New',
            'oeuvre[auteurs]' => 'Something New',
            'oeuvre[editions]' => 'Something New',
            'oeuvre[type]' => 'Something New',
            'oeuvre[serie]' => 'Something New',
            'oeuvre[Lieu]' => 'Something New',
        ]);

        self::assertResponseRedirects('/oeuvre/');

        $fixture = $this->oeuvreRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getPhoto());
        self::assertSame('Something New', $fixture[0]->getAnnee());
        self::assertSame('Something New', $fixture[0]->getAuteurs());
        self::assertSame('Something New', $fixture[0]->getEditions());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getSerie());
        self::assertSame('Something New', $fixture[0]->getLieu());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Oeuvre();
        $fixture->setTitre('Value');
        $fixture->setPhoto('Value');
        $fixture->setAnnee('Value');
        $fixture->setAuteurs('Value');
        $fixture->setEditions('Value');
        $fixture->setType('Value');
        $fixture->setSerie('Value');
        $fixture->setLieu('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/oeuvre/');
        self::assertSame(0, $this->oeuvreRepository->count([]));
    }
}
