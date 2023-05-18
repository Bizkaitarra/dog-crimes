Feature:
  In order to prove X dogs where playing outside

  Scenario: Zero dogs where playing outside and no dogs placed
    Given a new game with crime "Cake" is created
    And the rule is that "0" dogs where playing outside
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: One dog was playing outside and one dog placed
    Given a new game with crime "Cake" is created
    And the rule is that "1" dogs where playing outside
    And "Cider" is placed in "1"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: One dog was playing outside and five dog placed
    Given a new game with crime "Cake" is created
    And the rule is that "1" dogs where playing outside
    And "Cider" is placed in "1"
    And "Ace" is placed in "2"
    And "Daisy" is placed in "3"
    And "Suzette" is placed in "4"
    And "Beans" is placed in "5"
    When the rule is checked
    Then the result is that the rule has been meet


  Scenario: Two dog where playing outside and five dog placed
    Given a new game with crime "Cake" is created
    And the rule is that "2" dogs where playing outside
    And "Cider" is placed in "1"
    And "Ace" is placed in "2"
    And "Daisy" is placed in "3"
    And "Suzette" is placed in "4"
    And "Beans" is placed in "5"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Two dog where playing outside and four dog placed
    Given a new game with crime "Cake" is created
    And the rule is that "2" dogs where playing outside
    And "Cider" is placed in "1"
    And "Ace" is placed in "2"
    And "Daisy" is placed in "3"
    And "Suzette" is placed in "4"
    When the rule is checked
    Then the result is that the rule has been meet

  Scenario: Two dog where playing outside and three dog placed
    Given a new game with crime "Cake" is created
    And the rule is that "2" dogs where playing outside
    And "Cider" is placed in "1"
    And "Ace" is placed in "2"
    And "Daisy" is placed in "3"
    When the rule is checked
    Then the result is that the rule has been violated