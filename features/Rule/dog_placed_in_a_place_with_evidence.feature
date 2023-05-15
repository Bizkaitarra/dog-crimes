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

  Scenario: Cider should be placed in a place with a Rope Toy and the place has a rope toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Cider" is in a place with "Rope_toy"
    And "Cider" is placed in "2"
    When the rule is checked
    Then the result is that the rule has been meet

  Scenario: A dog with bandana should be placed in a place with a Rope Toy but no dogs are placed
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "Bandana" is in a place with "Rope_toy"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: A dog with bandana should be placed in a place with a Rope Toy and one of them is placed and has not a rope toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "Bandana" is in a place with "Rope_toy"
    And "Daisy" is placed in "1"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: A dog with bandana should be placed in a place with a Rope Toy and both of them is placed and has not a rope toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "Bandana" is in a place with "Rope_toy"
    And "Daisy" is placed in "1"
    And "Ace" is placed in "3"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: A dog with bandana should be placed in a place with a Rope Toy and both of them are placed and one has a rope toy
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "Bandana" is in a place with "Rope_toy"
    And "Daisy" is placed in "2"
    And "Ace" is placed in "3"
    When the rule is checked
    Then the result is that the rule has been meet