<?php

namespace Zwuiix\AdvancedRank\interface;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedRank\lib\jojoe77777\FormAPI\CustomForm;
use Zwuiix\AdvancedRank\rank\Rank;

final class ManageForm
{
    use SingletonTrait;

    public function create(Player $player, Rank $rank): void
    {
        $dropDown=["Give", "Set", "Info", "List", "AddPermission", "RemovePermission", "Create", "Delete"];
        $form = new CustomForm(function (Player $player, ?array $data) use ($dropDown): void {
            if (is_null($data)) return;
            if(!$data[1]) return;
            $player->chat("/rank ".strtolower($dropDown[$data[0]]));
        });
        $form->setTitle("Manage a {$rank->getName()} Rank");

        $form->addDropdown("Category", $dropDown);
        $form->addToggle("Confirm ?", false);
        $player->sendForm($form);
    }
}