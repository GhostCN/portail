 $(document).ready(function(){
    function tranferLocal(somme) {
        switch (true) {
            case (somme>0 && somme<495):
                $(".CalMtn").html("25")
                break;
            case (somme>=495 && somme<1100):
                $(".CalMtn").html("90")
                break;
            case (somme>=1100 && somme<3000):
                $(".CalMtn").html("180")
                break;
            case (somme>=3000 && somme<5000):
                $(".CalMtn").html("300")
                break;
            case (somme>=5000 && somme<10000):
                $(".CalMtn").html("500")
                break;
            case (somme>=10000 && somme<15000):
                $(".CalMtn").html("700")
                break;
            case (somme>=15000 && somme<20000):
                $(".CalMtn").html("900")
                break;
            case (somme>=20000 && somme<35000):
                $(".CalMtn").html("1400")
                break;
            case (somme>=35000 && somme<60000):
                $(".CalMtn").html("1700")
                break;
            case (somme>=60000 && somme<100000):
                $(".CalMtn").html("2600")
                break;
            case (somme>=100000 && somme<175000):
                $(".CalMtn").html("3500")
                break;
            case (somme>=175000 && somme<200000):
                $(".CalMtn").html("4500")
                break;
            case (somme>=200000 && somme<300000):
                $(".CalMtn").html("6000")
                break;
            case (somme>=300000 && somme<400000):
                $(".CalMtn").html("8000")
                break;
            case (somme>=400000 && somme<750000):
                $(".CalMtn").html("11000")
                break;
            case (somme>=750000 && somme<=1980000):
                $(".CalMtn").html("20000")
                break;
            case (somme>1980000):
              $(".CalMtn").html("N/A")
              break;
            default:
              $(".CalMtn").html("0")
              break;
        }
    }

    function tranferLocalAvecCode(somme) {
        switch (true) {
            case (somme>0 && somme<500):
                $(".CalMtn").html("25")
                break;
            case (somme>=500 && somme<1105):
                $(".CalMtn").html("95")
                break;
            case (somme>=1105 && somme<3005):
                $(".CalMtn").html("190")
                break;
            case (somme>=3005 && somme<5005):
                $(".CalMtn").html("375")
                break;
            case (somme>=5005 && somme<10005):
                $(".CalMtn").html("600")
                break;
            case (somme>=10005 && somme<15005):
                $(".CalMtn").html("900")
                break;
            case (somme>=15005 && somme<20005):
                $(".CalMtn").html("1000")
                break;
            case (somme>=20005 && somme<35005):
                $(".CalMtn").html("1500")
                break;
            case (somme>=35005 && somme<60005):
                $(".CalMtn").html("2000")
                break;
            case (somme>=60005 && somme<100005):
                $(".CalMtn").html("3000")
                break;
            case (somme>=100005 && somme<175005):
                $(".CalMtn").html("3750")
                break;
            case (somme>=175005 && somme<=200005):
                $(".CalMtn").html("4600")
                break;
            case (somme>200005):
              $(".CalMtn").html("N/A")
              break;
            default:
                $(".CalMtn").html("0")
                break;
        }
    }

    function tranferInternational(somme) {
        switch (true) {
            case (somme>500 && somme<=20000):
                $(".CalMtn").html("500")
                break;
            case (somme>=20000 && somme<=35000):
                $(".CalMtn").html("700")
                break;
            case (somme>=35000 && somme<=200000):
                $(".CalMtn").html("3000")
                break;
            case (somme>=200000 && somme<=400000):
                $(".CalMtn").html("5000")
                break;
            case (somme>=400000 && somme<=1000000):
                $(".CalMtn").html("11000")
                break;
            case (somme>1000000):
              $(".CalMtn").html("N/A")
              break;
            default:
                $(".CalMtn").html("N/A")
                break;
        }
    }

    function paiement(somme) {
        switch (true) {
            case (somme<=5000):
                $(".CalMtn").html("250")
                break;
            case (somme<=10000):
                $(".CalMtn").html("400")
                break;
            case (somme<=20000):
                $(".CalMtn").html("500")
                break;
            case (somme<=60000):
                $(".CalMtn").html("800")
                break;
            case (somme<=175000):
                $(".CalMtn").html("1900")
                break;
            case (somme<=400000):
                $(".CalMtn").html("3900")
                break;
            case (somme<=1989100):
                $(".CalMtn").html("10900")
                break;
            case (somme>1989100):
              $(".CalMtn").html("N/A")
              break;
        }
    }
    
    function calculateur(service){
        if (service ==1)
            tranferLocal($(".mtn").val());
        if (service ==2)
            tranferLocalAvecCode($(".mtn").val());
        if (service ==3)
            tranferInternational($(".mtn").val());
        if (service ==4)
            paiement($(".mtn").val());
    }

    $(".mtn").on("input", function () {
        let a = $(this).val();
        let last = a[a.length -1];
        if(!last.search("[^0-9]")){
            $(".mtn").val(a.substring(0, a.length -1))
        }

        $(".mtn").val($(this).val())
        calculateur($(".service").val())
    })

     $(".service").on("change", function () {
         $(".service").val($(this).val())
         calculateur($(this).val());
     })

 });
