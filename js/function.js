
	/* function.js */


	/*
	 * �berpr�ft welcher RadioButton ausgew�hlt worden ist.
	 * RadioButtons: 1.Sch�ler 2.Lehrer 3.Administrator
	 * Ziel: Unn�tige Felder beim Benutzer anlegen zu entfernen
	*/
	function checkClickedUser() {
		var whichTyp = document.getElementsByName("typ");
		var laenge = whichTyp.length;
		for(i=0;i<laenge;i++) {
			if(whichTyp[i].checked) {
				if (whichTyp[i].value == "schueler") {
					document.location.href = "index.php?section=create_user&typ=schueler";
				}
				if (whichTyp[i].value == "lehrer") {
					document.location.href = "index.php?section=create_user&typ=lehrer";			
				}
				if (whichTyp[i].value == "admin") {
					document.location.href = "index.php?section=create_user&typ=admin";
				}
			}
		}
	}
	
	