function validation(){
    var valid = true;

    document.getElementById("r1").innerHTML = "";
    document.getElementById("r2").innerHTML = "";
    document.getElementById("r3").innerHTML = "";
    document.getElementById("r4").innerHTML = "";
	
	const bookId = document.getElementById("bookid").value;
    const bookName = document.getElementById("bookName").value;
    const bookEdition = document.getElementById("bookEdition").value;
    const bookPrice = document.getElementById("bookPrice").value;
    
	if (bookId === '') {
	     document.getElementById("r1").innerHTML = "<span style='color:red;'>*Please enter the Book ID!!!</span>";
	     valid = false;
	 }
	
	 if (bookName === '') {
	     document.getElementById("r2").innerHTML = "<span style='color:red;'>*Please enter the Book Name!!!</span>";
	     valid = false;
	 }
	
	 if (bookEdition === '') {
	     document.getElementById("r3").innerHTML = "<span style='color:red;'>*Please enter the Book Edition!!!</span>";
	     valid = false;
	 }
	
	 if (bookPrice === '') {
	     document.getElementById("r4").innerHTML = "<span style='color:red;'>*Please enter the Book Price!!!</span>";
	     valid = false;
	 }
	 
    if(valid)
    {
        setTimeout(() => {
            window.alert(" successfully submitted!!!");
        }, 0);
    }

    return valid;
}