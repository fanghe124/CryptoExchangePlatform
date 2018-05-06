<?php


function remove_portfolio_coin($ids) {
	
	$userids3 = get_userid();
	
    db()->query("DELETE FROM portfolio WHERE userid = '".$userids3."' AND id = ".$ids."");
}


function save_portfolio_coin($purchase,$sold,$amount,$rate,$date) {
    db()->query("INSERT INTO portfolio (userid,base,quote,amount,rate,date_created)VALUES(?,?,?,?,?,?)",
        get_userid(),$purchase,$sold,$amount,$rate,$date);
}


function get_portfolio_coins() {

    $query = db()->query("SELECT * FROM portfolio WHERE userid=? ORDER BY id DESC", get_userid());
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_unique_portfolio_coins() {
    $id = get_userid();
    $query = db()->query("SELECT DISTINCT(base) FROM portfolio WHERE userid=? ", $id);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_portfolio_coin_detail($coin) {
    $query = db()->query("SELECT count(id) as coin_count,sum(amount) as quantity,sum(rate*amount) as total_rate FROM portfolio WHERE userid=? AND base=?", get_userid(), $coin);
    return $query->fetch(PDO::FETCH_ASSOC);
}

