UPDATE clients
SET
S_CUSTCODE = LPAD(S_CUSTCODE, 8, '0'),
S_AGNTCODE = LPAD(S_AGNTCODE, 8, '0'),
S_TOWNCODE = LPAD(S_TOWNCODE, 4, '0');

THIS QUERY BELONGS TO client table, need this to change para mag match yung mga datas...
