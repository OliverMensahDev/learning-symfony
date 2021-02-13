<?php

namespace  App\ConsoleCommands;

use App\Entity\ProductId;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddProductIdToExistingProducts extends  Command
{
    private  Connection$connection;

    public function __construct(Connection $connection)
    {
        parent::__construct(null);
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setName("Product:add-productId-to-product")
            ->setDescription("This adds product Ids to existing products with no product id");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select('id')
            ->from('product')
            ->where("product_id = '' ");
        $counter = 0;
        while (($row = $stmt->execute()->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $uuid = ProductId::generate()->toString();
            $output->writeln('Adding Product UUID '.$uuid);
            $this->updateSignupUuid((int) $row['id'], $uuid);
            ++$counter;
        }
        $output->writeln($counter.' uuid(s) added. Done!');

        return 0;
    }

    private function updateSignupUuid(int $id, string $uuid): void
    {
        $this->connection->createQueryBuilder()
            ->update('product')
            ->set('product_id', ':productId')
            ->where('id = :id')
            ->setParameters(
                [
                    'productId' => $uuid,
                    'id' => $id,
                ]
            )->execute();
    }

}
