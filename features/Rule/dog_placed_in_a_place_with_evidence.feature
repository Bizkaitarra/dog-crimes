Feature:
  In order to prove dog in a place with an evidence

  Scenario: Cider is placed in a place with a Rope Toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Cider" is in a place with "Rope_toy"
    When the rule is checked
    Then the result is that the rule has been meet