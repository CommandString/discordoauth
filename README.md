# commandstring/discordoauth #

An easier way to get discord OAuth tokens

# Requirements #
* PHP 8.1=<
* Composer 2
* Registered Discord application

# Getting Token
You will need to retrieve your discord application's `client_id` and `client_secret`. After retrieving those you can instantiate the `\CommandString\DiscordOAuth\OAuth` class.

```php
$OAuth = (new OAuth("http://localhost:8000", $client_id, $client_secret));
```

You will then need to define scopes by using the `addScopes` method. You can either supply a scope string or supply a Scopes enum.

```php
$OAuth->addScopes(Scopes::IDENTIFY);
```

Afterwards you can then generate a url for the authorize endpoint by invoking the `buildAuthorizeUrl` method.

```php
$authUrl - $OAuth->buildAuthorizeUrl();
```

After the client is redirected you can then use the `getToken` method for retrieving the access token.

```php
$tokenRes = $OAuth->getToken($_GET["code"]);
```

*You can supply your own `\React\Http\Browser` in the second argument of this method*

`$tokenRes` will be an stdClass with the following structure.

```json
{
    "access_token": "<string>",
    "expires_in": "<int>",
    "refresh_token": "<string>",
    "scope": "<string>",
    "token_type": "<string>"
}
```

You can also refresh your token with the refreshToken method...

```php
$newTokenRes = $OAuth->refreshToken($tokenRes->refresh_token);
```

# Getting user

```php
$user = User::getWithToken($tokenRes->token_type, $tokenRes->access_token);
```

*Note: All properties of the user are readonly.*