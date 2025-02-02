<?php

namespace App\Tests\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SerieControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $serieRepository;
    private string $path = '/serie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->serieRepository = $this->manager->getRepository(Serie::class);

        foreach ($this->serieRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Serie index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'serie[titre]' => 'Testing',
            'serie[nbtomes]' => 'Testing',
            'serie[info]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->serieRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Serie();
        $fixture->setTitre('My Title');
        $fixture->setNbtomes('My Title');
        $fixture->setInfo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Serie');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Serie();
        $fixture->setTitre('Value');
        $fixture->setNbtomes('Value');
        $fixture->setInfo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'serie[titre]' => 'Something New',
            'serie[nbtomes]' => 'Something New',
            'serie[info]' => 'Something New',
        ]);

        self::assertResponseRedirects('/serie/');

        $fixture = $this->serieRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getNbtomes());
        self::assertSame('Something New', $fixture[0]->getInfo());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Serie();
        $fixture->setTitre('Value');
        $fixture->setNbtomes('Value');
        $fixture->setInfo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/serie/');
        self::assertSame(0, $this->serieRepository->count([]));
    }
}
