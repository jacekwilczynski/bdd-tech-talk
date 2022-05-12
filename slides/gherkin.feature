Feature: Hiding empty product categories
    As a customer
    I want categories that do not have products to be invisible
    So that I don't waste time while browsing the shop

    Scenario: Only categories with active products are visible
        Given there are categories
        | name    | active products | inactive products |
        | Laptops | 1               | 0                 |
        | Phones  | 0               | 1                 |
        | Tablets | 0               | 0                 |
        When I open the homepage
        Then I should see only categories
        | name    |
        | Laptops |

    Scenario: Category with one product is visible but category with no products or only inactive products is invisible
        Given there are products
        | id                               | active |
        | 6e6c93af54b6413788c64afd0dd4e3cd | true   |
        | 865d8292885242a6bdca0fdd6e63b70d | false  |
        And there are categories
        | id                               | name    |
        | b5e33b1871fc4ce6a4f068eeb62a638c | Laptops |
        | c208341403cf4ac8b0286d93530f0f21 | Phones  |
        | f2143ebb864c447d95cc28760754e074 | Tablets |
        And there are product categories
        | product id                       | category id |
        | 6e6c93af54b6413788c64afd0dd4e3cd | b5e33b1871fc4ce6a4f068eeb62a638c |
        | 865d8292885242a6bdca0fdd6e63b70d | c208341403cf4ac8b0286d93530f0f21 |
        When I go to URL "/"
        And I wait 1 second
        Then element "li.navigation-category > a" with text "Laptop" should be in the HTML
        And element "li.navigation-category > a" with text "Phones" should not be in the HTML
        And element "li.navigation-category > a" with text "Tablets" should not be in the HTML
