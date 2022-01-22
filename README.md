# Laravel Bókun Appstore connector

Adds support for the Bókun appstore and both GraphQL & Legacy API to a laravel installation.

## Installation

You can install the package via composer:

```json
{
    "require": {
        "advtravel/laravel-bokun": "dev-main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/advtravel/laravel-bokun"
        }
    ]
}
```

## Usage

Simple use case: Make single custom requests to the Bókun GraphQL API:

```php
use Adventures\LaravelBokun\MakesBokunRequests;

class MyClass {
    use MakesBokunRequests;

    public function foo() {
        $this->makeRequest(
            'query vendor {vendor {id}}',
            $this->access_token
        );
    }
}
```

### Bókun Appstore connection

Other use case: Connect via a controller to the Bókun AppStore:

```php
use Adventures\LaravelBokun\AnswersBokunAppstoreRequests;
use Adventures\LaravelBokun\BokunAppConfig;
use Adventures\LaravelBokun\BokunUninstallRequest;

class BokunController extends Controller
{
    use AnswersBokunAppstoreRequests;

    protected function getAppConfig(): BokunAppConfig
    {
        return new BokunAppConfig(...);
    }

    public function accessCodeRequest(Request $request):
    {
        $access_token_response =
            $this->handleAccessCodeRequest($request);

        // handle the access token, e.g. save it to database,
        // log the operator in, get more vendor info etc.

        // See advtravel/bokun-app-template for full example
    }

    public function uninstallRequest(BokunUninstallRequest $request)
    {
        $vendor_id =
            $this->handleUninstallRequest($request);

        // ...
    }
}

// routing


Route::prefix('bokun')->name('bokun.')->group(function () {
    Route::get(
        '/initial',
        // This method is provided by AnswersBokunAppstoreRequests
        [BokunController::class, 'initialRequest']
    );
    Route::get(
        '/accessCode',
        [BokunController::class, 'accessCodeRequest']
    );
    Route::post(
        '/uninstall',
        [BokunController::class, 'uninstallRequest']
    );
});

```

### GraphQL: Connections, queries & mutations

```php
use Adventures\LaravelBokun\BokunAppConfig;
use Adventures\LaravelBokun\GraphQL\Connection;

$config = new BokunAppConfig(...);
$connection = new Connection($config, $access_token);
```

```php
use Adventures\LaravelBokun\GraphQL\Query;
use Adventures\LaravelBokun\GraphQL\DTOs\ScheduleFilterInput;

$query = new class extends Query {
    public function getName(): string {
        return 'experienceSchedule';
    }

    public function getValidInputs(): array {
        return [
            'filter' => ScheduleFilterInput::class,
        ];
    }
};

$connection->executeQuery(
    $query->withArgument(
        'filter',
        new ScheduleFilterInput(...)
    )
);

// There is nothing different on our side for mutations
// vs queries, the only difference is the keyword sent
// to Bókun
$conncetion->executeMutation($query);
```

```php
use Adventures\LaravelBokun\GraphQL\PagedQuery;
use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceFilterInput;
use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceSortInput;

$pagedQuery = new class extends PagedQuery {
    public function getName(): string {
        return 'experiences';
    }

    public function getValidInputs(): array {
        return [
            'sort' => ExperienceSortInput::class,
            'filter' => ExperienceFilterInput::class,
        ] + parent::pagedValidInputs();
    }
}
$connection->executePagedQuery($pagedQuery);
```

### Legacy REST API

In order to connect to the Legacy REST API, you need to include the corresponding access scope in your application configuration. From that moment on, all users that already have the application installed will get again a promt asking them to confirm permissions (the same dialog that new installations get) and then on an accessCode request the `AccessTokenResponse` includes the legacy API access key & secret key for you to save. This key-pair can then be used to initiate a `RestApi` instance:

```php
use Adventures\LaravelBokun\Legacy;

$client = new RestApi($access_key, $secret_key, $base_uri);

$activity = $client->makeRequest('GET', '/activity.json/123');
$response = $client->makeRequest('POST', '/foo.bar/123', $body_as_array);
```

The `$base_uri` has a default to the Bókun live environment, set to `https://api.bokuntest.com/` to connect to the test instance. The body data is passed as an array that will be JSON encoded on sending it to the API.

## DTOs

There is a `Adventures\LaravelBokun\GraphQL\DTOs\DTO` abstract class that a lot of other DTO classes extend. This class handles three scenarios:

- Encoding of DTO instance into the format required for queries / mutations as parameters
- Listing recursively all fields for a query / mutation
- Converting the API result back into a DTO tree

### Example scenario

```php
use Adventures\LaravelBokun\GraphQL\DTOs\DTO;
use Adventures\LaravelBokun\ArrayOf;

class Backpack extends DTO {
    public function __construct(
        public string $name,
        #[ArrayOf(BackpackItem::class)]
        public array $items,
        public int $owner_id,
    ) {}
}

class BackpackItem extends DTO {
    public function __construct(
        public string $name,
        public int $weight_in_grams,
        public string $color,
    ) {}
}
```

#### Encoding into parameters

```php
$backpack = new Backpack(
    "My little backpack",
    [
        new BackpackItem("Bananas", 1000, "yellow"),
        new BackpackItem("Cheese", 500, "white"),
        new BackpackItem("Apples", 1000, "red"),
    ],
    42,
);

$parameters = (string) $backpack;
```

```
name: "My little backpack", items: [
    {name: "Bananas", weight_in_grams: 1000, color: "yellow"},
    {name: "Cheese", weight_in_grams: 500, color: "white"},
    {name: "Apples", weight_in_grams: 1000, color: "red"}
], owner_id: 42
```
(Line breaks added for readability)

#### Decoding

Decoding works the same, just the other way round:

```php
$backpack = Backpack::fromArray([
    'name' => "My big backpack",
    'items' => [
        [
            'name' => "Tent",
            'weight_in_grams' => 2000,
            'color' => "red"
        ],
        //...
    ],
    'owner_id' => 42
]);
```

By using the `#[ArrayOf(OtherDTO::class)]` attribute, the DTO class can know into what sub-DTOs array items should be converted. `ArrayOf` can also handle `string`, `int`, `float` and `bool`.

#### Listing all fields

```php
$this->makeRequest(Backpack::listFieldsForQuery(), $access_token);
```
Result:
```php
"name, items { name, weight_in_grams, color }, owner_id"
```

You can use `[DTO]::onlyUse(...$field)` to limit the fields you want to get from a DTO. For example, if your application doesn't need anything else from experiences than their ID & name, you can add the following line to your AppServiceProvider:

```php
use Adventures\LaravelBokun\GraphQL\DTOs\Experience;

Experience::onlyUse('id', 'name');
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
