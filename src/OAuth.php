<?php

namespace CommandString\DiscordOAuth;

use CommandString\DiscordOAuth\Enums\Endpoints;
use CommandString\DiscordOAuth\Enums\ResponseType;
use CommandString\DiscordOAuth\Enums\Scopes;
use LogicException;
use React\Http\Browser;
use stdClass;

use function React\Async\await;

class OAuth {
    private string $state;
    private string $response_type;
    private string $endpoint;
    private array $scopes = [];

    public function __construct(
        private string $redirect_uri,
        private string $client_id,
        private string $client_secret
    ) {
        $this->response_type = ResponseType::CODE->value;
    }

    public function addScopes(string|Scopes ...$scopes): self
    {
        foreach ($scopes as $scope) {
            if (!is_string($scope)) {
                $scope = $scope->value;
            }

            if (in_array($scope, $this->scopes)) {
                throw new LogicException("Scope, $scope, has already been added.");
            }

            $this->scopes[] = $scope;
        }

        return $this;
    }

    public function setResponseType(string|ResponseType $response_type): self
    {
        $this->response_type = (!is_string($response_type)) ? $response_type->value : $response_type;

        return $this;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function verifyState(string $state): bool
    {
        if (!isset($this->state)) {
            throw new LogicException("The state parameter has not been defined.");
        }

        return ($this->state === $state);
    }

    public function buildAuthorizeUrl(): string
    {
        $keys = [
            "client_id",
            "redirect_uri",
            "scopes",
            "response_type"
        ];

        $params = [];

        foreach ($keys as $key) {
            if (!isset($this->$key) || empty($this->$key ?? "")) {
                continue;
            }

            if ($key === "scopes") {
                $params["scope"] = implode(" ", $this->scopes);
            } else {
                $params[$key] = $this->$key;
            }
        }

        return sprintf(Endpoints::AUTHORIZE->value."?%s", http_build_query($params));
    }

    public function getToken(string $code, ?Browser $browser = null): stdClass
    {
        if (is_null($browser)) {
            $browser = new \React\Http\Browser();
        }

        $data = [
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => "http://localhost:8000"
        ];

        $result = await(
            $browser->post(
                Endpoints::buildEndpointUrl("/oauth2/token"),
                [
                    "content-type" => "application/x-www-form-urlencoded"
                ],
                http_build_query($data)
            )
        );

        return json_decode($result->getBody());
    }

    public function refreshToken(string $refresh_token, ?Browser $browser = null): stdClass
    {
        if (is_null($browser)) {
            $browser = new \React\Http\Browser();
        }

        $data = [
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ];

        $result = await(
            $browser->post(
                Endpoints::buildEndpointUrl("/oauth2/token"),
                [
                    "content-type" => "application/x-www-form-urlencoded"
                ],
                http_build_query($data)
            )
        );

        return json_decode($result->getBody());
    }
}