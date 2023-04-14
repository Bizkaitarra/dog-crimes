<?php

namespace App;

use App\Dog\Dog;

class Game
{
    /** @var Dog[] */
    public readonly array $dogs;

    /** @var BoardPlace[] */
    public readonly array $board;

    /** @var Rule[] */
    private array $rules;

    public function __construct(array $rules)
    {
        $this->buildBoard();
        $this->buildDogs();
        $this->rules = $rules;
    }

    private function buildBoard()
    {
        $tennisBall = new Evidence(Evidence::TENNIS_BALL);
        $sock = new Evidence(Evidence::SOCK);
        $rawhide = new Evidence(Evidence::RAWHIDE);
        $stick = new Evidence(Evidence::STICK);
        $pawPrint = new Evidence(Evidence::PAW_PRINT);
        $ropeToy = new Evidence(Evidence::ROPE_TOY);

        $pillow = new Crime(Crime::PILLOW, $crime === Crime::PILLOW);
        $flowerPot = new Crime(Crime::FLOWER_POT, $crime === Crime::FLOWER_POT);
        $poop = new Crime(Crime::POOP, $crime === Crime::POOP);
        $homework = new Crime(Crime::HOMEWORK, $crime === Crime::HOMEWORK);
        $cake = new Crime(Crime::CAKE, $crime === Crime::CAKE);
        $shoes = new Crime(Crime::SHOES, $crime === Crime::SHOES);

        $boardPlace1 = new BoardPlace(1, $tennisBall, $sock, $homework);
        $boardPlace2 = new BoardPlace(2, $ropeToy, $pawPrint, $pillow);
        $boardPlace3 = new BoardPlace(3, $rawhide, $sock, $flowerPot);
        $boardPlace4 = new BoardPlace(4, $ropeToy, $stick, $cake);
        $boardPlace5 = new BoardPlace(5, $pawPrint, $tennisBall, $poop);
        $boardPlace6 = new BoardPlace(6, $rawhide, $stick, $shoes);

        $boardPlace1->addFrontBoard($boardPlace4);
        $boardPlace1->addLeftBoard($boardPlace2);
        $boardPlace1->addRightBoard($boardPlace6);

        $boardPlace2->addFrontBoard($boardPlace6);
        $boardPlace2->addLeftBoard($boardPlace3);
        $boardPlace2->addRightBoard($boardPlace1);

        $boardPlace3->addFrontBoard($boardPlace5);
        $boardPlace3->addLeftBoard($boardPlace4);
        $boardPlace3->addRightBoard($boardPlace2);

        $boardPlace4->addFrontBoard($boardPlace1);
        $boardPlace4->addLeftBoard($boardPlace5);
        $boardPlace4->addRightBoard($boardPlace3);

        $boardPlace5->addFrontBoard($boardPlace3);
        $boardPlace5->addLeftBoard($boardPlace6);
        $boardPlace5->addRightBoard($boardPlace4);

        $boardPlace6->addFrontBoard($boardPlace2);
        $boardPlace6->addLeftBoard($boardPlace1);
        $boardPlace6->addRightBoard($boardPlace5);

        $this->board = [
            $boardPlace1,
            $boardPlace2,
            $boardPlace3,
            $boardPlace4,
            $boardPlace5,
            $boardPlace6
        ];
    }

    private function buildDogs()
    {

        $this->dogs[] = new Dog(
            'Daisy',
            true,
            true,
            false,
            false,
            false,
            false
        );

        $this->dogs[] = new Dog(
            'Ace',
            true,
            false,
            true,
            false,
            false,
            false
        );

        $this->dogs[] = new Dog(
            'Cider',
            false,
            false,
            false,
            true,
            true,
            false
        );

        $this->dogs[] = new Dog(
            'Suzette',
            false,
            false,
            false,
            false,
            true,
            true
        );

        $this->dogs[] = new Dog(
            'Beans',
            false,
            true,
            false,
            false,
            false,
            true
        );

        $this->dogs[] = new Dog(
            'Pepper',
            false,
            false,
            true,
            true,
            false,
            false
        );
    }


}