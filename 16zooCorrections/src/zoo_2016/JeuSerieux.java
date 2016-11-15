package zoo_2016;

/**
 *
 * @author sylvain
 */
import client.ClientNormal;
import java.util.ArrayList;

public class JeuSerieux {

    static private ArrayList<ClientNormal> mesClients;
    private static final int NBCLIENT = 25;

    private static void run(int nb) {
        int i;
        for (i = 0; i < nb; i++) {
            System.out.println("Action " + i);
            
            for (ClientNormal c : mesClients) {
                if (i > 0) {
                    c.choisir();
                    c.faireAgir();
                }
                System.out.println("        " +  c.toString());

            }
            removeClient();
            if (mesClients.isEmpty()) {
                break;
            } 
        }
    }

    private static void removeClient() {
        boolean trouve = true;
        while (trouve) {
            trouve = false;

            for (ClientNormal c : mesClients) {
                if (c.estSortie()) {
                    trouve = true;
                    mesClients.remove(c);
                    break;
                }

            }
        }
    }

    public static void main(String args[]) {
        // initialisations
        // instanciation de la fabrique d'envie
        FabriqueEnvie maFab = new FabriqueEnvie();
        // instanciation des clients
        mesClients = new ArrayList<>();
        //List <Envie> desEnvies = maFab.getTabEnvie();;
        //List <Envie> desEnvies = maFab.getTabEnvie();
        for (int i = 0; i < NBCLIENT; i++) {
            mesClients.add(new ClientNormal(maFab.getTabEnvie()));
        }

        // déroulement du programme
        run(200);
    }

}
