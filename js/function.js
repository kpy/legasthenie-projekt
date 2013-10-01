
	/* function.js */


	/*
	 * Überprüft welcher RadioButton ausgewählt worden ist.
	 * RadioButtons: 1.Schüler 2.Lehrer 3.Administrator
	 * Ziel: Unnötige Felder beim Benutzer anlegen zu entfernen
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
	
	