{"filter":false,"title":"2016_05_17_153001_create_projects_table.php","tooltip":"/database/migrations/2016_05_17_153001_create_projects_table.php","undoManager":{"mark":5,"position":5,"stack":[[{"start":{"row":18,"column":33},"end":{"row":19,"column":0},"action":"insert","lines":["",""],"id":2},{"start":{"row":19,"column":0},"end":{"row":19,"column":12},"action":"insert","lines":["            "]}],[{"start":{"row":19,"column":12},"end":{"row":21,"column":79},"action":"insert","lines":["$table->integer('id_user')->unsigned()->default(0);","","$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');"],"id":3}],[{"start":{"row":19,"column":63},"end":{"row":20,"column":0},"action":"remove","lines":["",""],"id":4}],[{"start":{"row":20,"column":0},"end":{"row":20,"column":4},"action":"insert","lines":["    "],"id":5}],[{"start":{"row":20,"column":4},"end":{"row":20,"column":8},"action":"insert","lines":["    "],"id":6}],[{"start":{"row":20,"column":8},"end":{"row":20,"column":12},"action":"insert","lines":["    "],"id":7}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":19,"column":29},"end":{"row":19,"column":36},"isBackwards":true},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1463499057671,"hash":"36e505cf2e12f2c88972514cfa5cef215f807727"}