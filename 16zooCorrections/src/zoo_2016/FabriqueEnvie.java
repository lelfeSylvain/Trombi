package zoo_2016;

import envies.Comp_Acheter;
import envies.Comportement;
import envies.Envie;
import envies.Comp_Marcher;
import envies.Comp_Regarder;
import java.util.ArrayList;
import java.util.List;

class FabriqueEnvie {

    private List <Envie>  tabEnvie;

    public FabriqueEnvie() {
        tabEnvie = new ArrayList<>();
        Comportement c;
        c = new Comp_Marcher();
        tabEnvie.add( new Envie(c, 0.8));
        c = new Comp_Acheter();
        tabEnvie.add( new Envie(c, 0.05));
        c = new Comp_Regarder();
        tabEnvie.add( new Envie(c, 0.7));
    }

    public ArrayList <Envie> getTabEnvie() {
        ArrayList <Envie> t = new ArrayList<>();
        for( Envie e : tabEnvie){
            t.add( e.clone());
        }
        return t;
    }
}
