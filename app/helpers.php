<?php
use App\Models\Card;
use App\Models\WipViolation;
use Illuminate\Support\Facades\Auth;

function checkWipViolation(Card $card, $reason = "", $from = null){
    $column = $card->column()->with('cards')->first();
    $cardsNum = count($column->cards);
    if($column->WIP > 0 && $column->WIP < $cardsNum)
        insertWipViolation($card, $reason, $from);
    else {
        $parent = $column->parent()->with('children.cards')->first();
        $cardsNum = 0;
        foreach ($parent->children as $child){
            $cardsNum += count($child->cards);
        }
        if($parent->WIP > 0 &&$parent->WIP < $cardsNum)
            insertWipViolation($card, $reason . " (na starševski tabeli)", $from);
    }

}

function insertWipViolation(Card $card, $reason = "", $from = null){
    WipViolation::create([
        'user_id' => Auth::user()->id,
        'old_column_id' => isset($from) ? $from : $card->column_id,
        'new_column_id' => $card->column_id,
        'card_id' => $card->id,
        'reason' => $reason,

    ]);
}