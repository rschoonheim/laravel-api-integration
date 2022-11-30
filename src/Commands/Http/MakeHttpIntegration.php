<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Commands\Http;

use Illuminate\Console\Command;
use Rschoonheim\LaravelApiIntegration\Exceptions\ApiDirectoryAlreadyExistsException;
use Rschoonheim\LaravelApiIntegration\Facades\Directories;

class MakeHttpIntegration extends Command
{
    protected $signature = 'integration:http:create';

    protected $description = 'Create a new HTTP integration';

    public function handle(): int
    {
        $this->output->title('Creating a new HTTP integration.');

        /**
         * Http folder should exist in `app/Integrations`
         * If it doesn't exist, create it.
         * ----------------------------------------------
         */
        try {
            Directories::createApiDirectory('Http');
        } catch (ApiDirectoryAlreadyExistsException) {
        }

        /**
         * Ask the user for the name of the integration.
         * ---------------------------------------------
         * A name cannot be empty,
         * A name cannot contain spaces,
         * A name cannot contain special characters,
         * A name cannot start with a number.
         */
        askName:
        $name = ucfirst($this->ask('What is the name of your integration?'));
        if (empty($name)) {
            $this->output->error('You must provide a name for your integration.');
            goto askName;
        }

        if (preg_match('/\s/', $name)) {
            $this->output->error('Your integration name cannot contain spaces.');
            goto askName;
        }

        if (preg_match('/[^a-zA-Z0-9]/', $name)) {
            $this->output->error('Your integration name cannot contain special characters.');
            goto askName;
        }

        if (preg_match('/^\d/', $name)) {
            $this->output->error('Your integration name cannot start with a number.');
            goto askName;
        }

        try {
            Directories::createApiDirectory("Http/{$name}");
        } catch (ApiDirectoryAlreadyExistsException) {
            $this->output->error("An integration with the name '{$name}' already exists.");
            goto askName;
        }

        /**
         * Ask the user for the base URL for the integration.
         * --------------------------------------------------
         * A base URL cannot be empty,
         * A base URL must be a valid URL,
         * A base URL must be a valid HTTPS URL.
         */
        askBaseUrl:
        $baseUrl = $this->ask('What is the base URL for your integration?');
        if (empty($baseUrl)) {
            $this->output->error('You must provide a base URL for your integration.');
            goto askBaseUrl;
        }

        if (! filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            $this->output->error('Your base URL must be a valid URL.');
            goto askBaseUrl;
        }

        if (! preg_match('/^https:\/\//', $baseUrl)) {
            $this->output->error('Your base URL must be a valid HTTPS URL.');
            goto askBaseUrl;
        }

        /**
         * Generate the client based on the provided name and base URL.
         */
        \Storage::disk('api-integration')->put(
            "Http/{$name}/HttpClient.php",
            $this->generateHttpClientSource($name, $baseUrl)
        );

        $this->output->success('Http integration created successfully.');

        return self::SUCCESS;
    }

    private function generateHttpClientSource(mixed $name, mixed $baseUrl)
    {
        $client = <<<EOT
<?php

declare(strict_types=1);

namespace App\Integrations\Http\\$name;

use Illuminate\Http\Client\Factory;

class :name extends Factory
{
    public function __construct()
    {
        parent::__construct();
        \$this->baseUrl(':baseUrl');
    }
}
EOT;

        $client = str_replace(':name', $name, $client);

        return str_replace(':baseUrl', $baseUrl, $client);
    }
}
