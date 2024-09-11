function validation(){
    const form = document.getElementById("varun");
    const reg = form.getElementsByTagName("input");
    console.log(reg[0].value);
    var valid = true;
    var pattern = /^[a-zA-Z]{2}\d{5}$/;

    document.getElementById("r1").innerHTML = "";
    document.getElementById("r2").innerHTML = "";
    document.getElementById("r3").innerHTML = "";
    document.getElementById("r4").innerHTML = "";
    document.getElementById("r6").innerHTML = "";
    document.getElementById("r7").innerHTML = "";
    document.getElementById("r8").innerHTML = "";

    if(reg[0].value=='')
    {
        document.getElementById("r1").innerHTML="<h1>*Please enter the Registration Number!!!</h1>";
        valid = false;
    }
    
    if(reg[1].value == "")
    {
        document.getElementById("r2").innerHTML="<h1>*Please enter your name before submitting!!!</h1>";
        valid = false;
    }

    if(reg[2].value == "")
    {
        document.getElementById("r3").innerHTML="<h1>*Please enter your year before submitting!!!</h1>";
        valid = false;
    }
    
    if(reg[3].value == "")
    {
        document.getElementById("r4").innerHTML="<h1>*Please enter your semester before submitting!!!</h1>";
        valid = false;
    }

    if(reg[4].value == "")
    {
        document.getElementById("r6").innerHTML="<h1>*Please enter your subject code before submitting!!!</h1>";
        valid = false;
    }

    else
    {
        if(pattern.test(reg[4].value))
        {
            console.log("Correct subject code format");
        }
        else
        {
            document.getElementById("r6").innerHTML="<h1>*This subject code is not valid!!!</h1>";
            valid = false;
        }
    }

    if(reg[5].value == "")
    {
        document.getElementById("r7").innerHTML="<h1>*Please enter your subject name before submitting!!!</h1>";
        valid = false;
    }

    if(reg[6].value == "")
    {
        document.getElementById("r8").innerHTML="<h1>*Please enter your Date of Birth before submitting!!!</h1>";
        valid = false;
    }

    if(valid)
    {
        setTimeout(() => {
            document.getElementById("r1").innerHTML = "";
            document.getElementById("r2").innerHTML = "";
            document.getElementById("r3").innerHTML = "";
            document.getElementById("r4").innerHTML = "";
            document.getElementById("r6").innerHTML = "";
            document.getElementById("r7").innerHTML = "";
            document.getElementById("r8").innerHTML = "";
            window.alert("Form successfully submitted!!!");
        }, 0);
    }

    return valid;
}
