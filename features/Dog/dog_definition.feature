Feature:
  In order to prove dog definition

  Scenario: A empty dog definition should meet with all dogs
    Given a sample game
    And an undefined dog
    Then the dog definition should return "6" dogs

  Scenario: Dogs with bandana should return Ace and Daisy
    Given a sample game
    And an dog with "bandana"
    Then the following dogs meets definition:
      | Ace   |
      | Daisy |

  Scenario: Dogs with tan tail should return Ace and Daisy
    Given a sample game
    And an dog with "tan_tail"
    Then the following dogs meets definition:
      | Beans   |
      | Daisy |