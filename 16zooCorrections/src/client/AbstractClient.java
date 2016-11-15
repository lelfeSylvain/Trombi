package client;

import envies.Envie;
import envies.Comportement;
import java.util.ArrayList;

/**
 *
 * @author sylvain
 */
public abstract class AbstractClient {

    private ContexteClient monContexte;
    private Comportement monEnvieDuMoment;
    private ArrayList<Envie> mesEnvies;
    private String derniereAction;
    private int num;
    private static int nombre = 0;

    public AbstractClient() {
        this(null);
    }

    public AbstractClient(ArrayList<Envie> desEnvies) {
        num = nombre++;
        mesEnvies = desEnvies;
        monEnvieDuMoment = mesEnvies.get(0).getComportement();
        derniereAction = "Je viens d'arriver";
        monContexte = new ContexteClientConcret();
    }

    public void faireAgir() {
        derniereAction = monEnvieDuMoment.agir(monContexte);

    }

    public boolean estSortie() {
        return monContexte.getMaPosition().getMaPos() == 7;
    }

    public void choisir() {
        int i = 0, max = mesEnvies.size();
        double p;
        while (i < max) {
            p = Math.random();
            //System.out.println("         "+i+" _ "+mesEnvies.get(i).getProba()+" > "+p);
            if (mesEnvies.get(i).getProba() > p) {// si la probabilité de l'envie est réalisée
                monEnvieDuMoment = mesEnvies.get(i).getComportement();
                mesEnvies.get(i).reduireProba();// l'envie étant réalisée, elle devient moins probable...
                passerEnvieEnDernier(i);// vraiment moins probable.
                i = max;// on sort de la boucle
            } else {// l'envie n'est pas réalisée, elle devient plus probable.
                if (i + 1 < max) { // si c'est pas la dernière 
                    mesEnvies.get(i).augmenterProba();
                }
            }
            i++;
        }

    }

    private void passerEnvieEnDernier(int pos) {
        mesEnvies.add(mesEnvies.get(pos));
        mesEnvies.remove(pos);
    }

    public String toString() {
        String result = "";
        for (Envie e : mesEnvies) {
            result += e.toString() + " ";
        }
        return num + " : " + derniereAction + ", je suis devant le kiosque " + monContexte.getMaPosition().getMaPos() + " " + result;
    }

}
