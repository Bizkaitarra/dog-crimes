Feature:
  In order to prove dog in a place with an evidence

  Scenario: Cider should be placed in a place with a Rope Toy but is not placed
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Cider" is in a place with "Rope_toy"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: Cider should be placed in a place with a Rope Toy and the place has not a rope toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Cider" is in a place with "Rope_toy"
    And "Cider" is placed in "1"
    When the rule is checked
    Then the result is that the rule has been violated