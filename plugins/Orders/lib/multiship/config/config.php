<?php
  $config = new MultiShip_Config();
  $config -> client_id = 1507;
  $config -> sender_id = array(990);
  $config -> warehouse_id = array(649);
  $config -> requisite_id = array(419);
  $config -> api_url = "https://multiship.ru/OpenAPI_v3/";
  $config -> format = 'json';
  $config -> keys =
    array(
      'getPaymentMethods' => '12136cea92a4d3554e5388c40f54b423e89ae6f1edc8f56795d594c86fadc92a',
      'getDeliveryMethods' => '12136cea92a4d3554e5388c40f54b423bf46da90919123e8708a4de52328a9bf',
      'searchDeliveryList' => '12136cea92a4d3554e5388c40f54b4230870bdbe6c9fd17c6f043763a7cea29d',
      'createOrder' => '12136cea92a4d3554e5388c40f54b423e3ac43b45ad903bb6b0d063f9641b929',
      'confirmSenderOrder' => '12136cea92a4d3554e5388c40f54b423c38bab44300f1e7cd9f4432cdc6de0f2',
      'confirmSenderOrders' => '12136cea92a4d3554e5388c40f54b42394429866b676179c201ea607814c92b2',
      'confirmSenderParcel' => '12136cea92a4d3554e5388c40f54b423f89270edc5f970f39374fe135bde2f4e',
      'getSenderOrders' => '12136cea92a4d3554e5388c40f54b4238077e3711503efa601c5479b0849425a',
      'getSenderOrderLabel' => '12136cea92a4d3554e5388c40f54b42307d9949aa3251469b944095f49f98e42',
      'getSenderParcelLabel' => '12136cea92a4d3554e5388c40f54b423514a920e7bccdfc648c85928be1767a5',
      'getSenderOrderStatus' => '12136cea92a4d3554e5388c40f54b423e91bf75e489e47029d79bb4666378578',
      'getSenderOrderStatuses' => '12136cea92a4d3554e5388c40f54b4232a1e050df001b5ccdaf944769ab4bfc2',
      'getSenderNomenclature' => '12136cea92a4d3554e5388c40f54b423a8369e32b668e6e790665cc0c345004d',
      'getSenderGoodsBalans' => '12136cea92a4d3554e5388c40f54b4234f2a366bfad283c49dbc73a5aa02b064',
      'getIndex' => '12136cea92a4d3554e5388c40f54b42311337c7cbd8e85f54bdddde60583ce02',
      'autocomplete' => '12136cea92a4d3554e5388c40f54b42391c0f805e5667b0079799bc9003474bf',
    );