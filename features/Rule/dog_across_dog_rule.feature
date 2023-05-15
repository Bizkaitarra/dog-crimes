Feature:
  In order to prove dog across to dog rule

  Scenario: Cider and Ace should be across but no dogs are placed
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: Cider and Ace should be across and only ace is placed
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Ace" is placed in "1"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: Cider and Ace should be across and only ace and cider are placed, and they are across
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Ace" is placed across "Cider"
    When the rule is checked
    Then the result is that the rule has been meet

  Scenario: Cider and Ace should be across and only ace and cider are placed, and they are not across
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Ace" is placed in "1"
    And "Cider" is placed in "6"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Cider and Ace should be across and only ace and other dog is placed and they are not across
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Ace" is placed in "1"
    And "Pepper" is placed in "6"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: Cider and Ace should be across and only ace and other dog is placed and they are across
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Ace" is placed across "Pepper"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Cider and Ace should be across and only cider and other dog is placed and they are not across
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    And "Cider" is placed in "1"
    And "Pepper" is placed in "3"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: A dog with bandana (Daisy or Ace) and a dog with Bow (Suzette or Beans) should be across and no one is placed
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "bandana" is across a dog with "bow"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: A dog with bandana (Daisy or Ace) and a dog with Bow (Suzette or Beans) should be across and only Daisy and Beans are placed not across
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "bandana" is across a dog with "bow"
    And "Daisy" is placed in "1"
    And "Beans" is placed in "5"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated

  Scenario: A dog with bandana (Daisy or Ace) and a dog with Bow (Suzette or Beans) should be across and they are all placed and not across
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "bandana" is across a dog with "bow"
    And "Daisy" is placed in "1"
    And "Ace" is placed in "2"
    And "Suzette" is placed in "3"
    And "Beans" is placed in "5"
    When the rule is checked
    Then the result is that the rule has been violated


  Scenario: A dog with bandana (Daisy or Ace) and a dog with Bow (Suzette or Beans) should be across and a pair of them are across
    Given a new game with crime "Cake" is created
    And the rule is that a dog with "bandana" is across a dog with "bow"
    And "Daisy" is placed in "1"
    And "Ace" is placed in "2"
    And "Suzette" is placed in "6"
    And "Beans" is placed in "3"
    And "Cider" is placed in "4"
    When the rule is checked
    Then the result is that the rule has been meet

  Scenario: Ace and a dog with Bow (Suzette or Beans) should be across and Suzzete and Beans are across and Ace placed without dog across
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Ace" is across a dog with "bow"
    And "Suzette" is placed in "1"
    And "Beans" is placed in "4"
    And "Ace" is placed in "2"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Ace and a dog with Bow (Suzette or Beans) should be across and Ace has already a dog across
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Ace" is across a dog with "bow"
    And "Ace" is placed in "1"
    And "Cider" is placed in "4"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Ace and a dog with Bow (Suzette or Beans) should be across and Ace is not placed but Suzette and Beans are across
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Ace" is across a dog with "bow"
    And "Suzette" is placed in "1"
    And "Beans" is placed in "4"
    When the rule is checked
    Then the result is that the rule has been violated

  Scenario: Ace and a dog with Bow (Suzette or Beans) should be across and Ace is not placed but Suzette and Beans are across other dogs
    Given a new game with crime "Cake" is created
    And the rule is that a dog named "Ace" is across a dog with "bow"
    And "Suzette" is placed in "1"
    And "Cider" is placed in "4"
    And "Beans" is placed in "2"
    And "Pepper" is placed in "6"
    When the rule is checked
    Then the result is that the rule has been violated