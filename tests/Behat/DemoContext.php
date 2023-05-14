<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\RuleCompliance;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    private DogAcrossToDogRule $dogAcrossToDogRule;
    private Game $game;
    private RuleCompliance $ruleResult;

    /**
     * @Given the rule is that :firstDogName is across to :secondDogName
     */
    public function aDogWithNameIsAcrossOtherDogWithName(string $firstDogName, string $secondDogName): void
    {
        $this->dogAcrossToDogRule = new DogAcrossToDogRule(
            '',
            new DogDefinition($firstDogName, null, null, null, null, null, null),
            new DogDefinition($secondDogName, null, null, null, null, null, null),
        );
    }

    /**
     * @Given a new game with crime :crime is created
     */
    public function aNewGameIsCreated(string $crime) {
        $this->game = new Game([], $crime);
    }

    /**
     * @When the rule is checked
     */
    public function theRuleIsChecked() {
        $this->ruleResult = $this->dogAcrossToDogRule->meets($this->game);
    }

    /**
     * @Then the result is that the rule has been violated
     */
    public function theRuleHasBeenViolated() {
        return $this->ruleResult === RuleCompliance::ViolatesTheRule;
    }

    /**
     * @Then the result is that the rule has been meet
     */
    public function theRuleHasBeenMeet() {
        return $this->ruleResult === RuleCompliance::MeetsTheRule;
    }

    /**
     * @Then the result is that the rule has been meet not meet nor violated
     */
    public function theRuleHasBeenNotMeetNorViolateTheRule() {
        return $this->ruleResult === RuleCompliance::NotMeetNorViolateTheRule;
    }
}
