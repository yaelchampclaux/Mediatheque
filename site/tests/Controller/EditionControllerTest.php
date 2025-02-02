<?php

namespace App\Tests\Controller;

use App\Entity\Edition;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EditionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $editionRepository;
    private string $path = '/edition/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->editionRepository = $this->manager->getRepository(Edition::class);

        foreach ($this->editionRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Edition index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'edition[nom]' => 'Testing',
            'edition[siteweb]' => 'Testing',
            'edition[info]' => 'Testing',
            'edition[oeuvres]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->editionRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Edition();
        $fixture->setNom('My Title');
        $fixture->setSiteweb('My Title');
        $fixture->setInfo('My Title');
        $fixture->setOeuvres('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Edition');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Edition();
        $fixture->setNom('Value');
        $fixture->setSiteweb('Value');
        $fixture->setInfo('Value');
        $fixture->setOeuvres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'edition[nom]' => 'Something New',
            'edition[siteweb]' => 'Something New',
            'edition[info]' => 'Something New',
            'edition[oeuvres]' => 'Something New',
        ]);

        self::assertResponseRedirects('/edition/');

        $fixture = $this->editionRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getSiteweb());
        self::assertSame('Something New', $fixture[0]->getInfo());
        self::assertSame('Something New', $fixture[0]->getOeuvres());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Edition();
        $fixture->setNom('Value');
        $fixture->setSiteweb('Value');
        $fixture->setInfo('Value');
        $fixture->setOeuvres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/edition/');
        self::assertSame(0, $this->editionRepository->count([]));
    }
}
