[] spawn {
    waitUntil {sleep 0.3; alive player && {!isnull (findDisplay 46)}};

    sleep 2;

    if(isNil "VARIABLESECUALFCHEHGETREKT") then {
    	for "_i" from 0 to 1 step 0 do {
    		disableUserInput true;
       		cutText["Ce mod est une propriété d'Arma Life France. Son tilisation est interdite hors du serveur officiel.","BLACK"];
        	preProcessFile "ALF_Secu\crash.sqf";
    	};
    };
};