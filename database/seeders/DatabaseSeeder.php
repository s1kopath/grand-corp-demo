<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TeamSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            PrincipalSeeder::class,
            ProductSeeder::class,
            ProductPrincipalSeeder::class,
            QuotationSeeder::class,
            IndentSeeder::class,
            LetterOfCreditSeeder::class,
            ShipmentSeeder::class,
            ShipmentDocumentSeeder::class,
            CertificateSeeder::class,
            DebitNoteSeeder::class,
            AccountEntrySeeder::class,
            ParameterSeeder::class,
            BrandingSeeder::class,
            DataBankRecordSeeder::class,
            PriceHistorySeeder::class,
        ]);
    }
}
