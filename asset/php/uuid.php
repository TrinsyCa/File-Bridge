<?php
function generateUUID() {
    $data = openssl_random_pseudo_bytes(8);
    assert(strlen($data) == 8);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[7] = chr(ord($data[7]) & 0x3f | 0x80);

    return sprintf('%s-%s-%s',
        bin2hex(substr($data, 0, 4)),
        bin2hex(substr($data, 4, 2)),
        bin2hex(substr($data, 6, 2))
    );
}
function uuidExists($db, $uuid) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM files WHERE href = :uuid");
    $stmt->bindParam(":uuid", $uuid);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function generateUniqueUUID($db) {
    do {
        $uuid = generateUUID();
    } while (uuidExists($db, $uuid));
    return $uuid;
}