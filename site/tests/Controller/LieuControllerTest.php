<?php

namespace App\Tests\Controller;

use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LieuControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $lieuRepository;
    private string $path = '/lieu/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->lieuRepository = $this->manager->getRepository(Lieu::class);

        foreach ($this->lieuRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lieu index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'lieu[adresse]' => 'Testing',
            'lieu[latitude]' => 'Testing',
            'lieu[longitude]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->lieuRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lieu();
        $fixture->setAdresse('My Title');
        $fixture->setLatitude('My Title');
        $fixture->setLongitude('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lieu');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lieu();
        $fixture->setAdresse('Value');
        $fixture->setLatitude('Value');
        $fixture->setLongitude('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lieu[adresse]' => 'Something New',
            'lieu[latitude]' => 'Something New',
            'lieu[longitude]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lieu/');

        $fixture = $this->lieuRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getLatitude());
        self::assertSame('Something New', $fixture[0]->getLongitude());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lieu();
        $fixture->setAdresse('Value');
        $fixture->setLatitude('Value');
        $fixture->setLongitude('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/lieu/');
        self::assertSame(0, $this->lieuRepository->count([]));
    }
}
