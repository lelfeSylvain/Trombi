package envies;

public class Envie implements Cloneable {

    private Comportement monComportement;
    private double p;

    public Envie(Comportement c, double f) {
        monComportement = c;
        p = f;

    }

    public double getProba() {
        return p;
    }

    public void setProba(double f) {
        if (f < 1) {
            if (f > 0) {
                p = f;
            } else {
                p = 0;
            }
        } else {
            p = 1;
        }

    }

    public void reduireProba() {
        p = p / 2;
    }

    public void augmenterProba() {
        p = p + 0.05;
    }

    public Comportement getComportement() {
        return monComportement;
    }

    public String toString() {
        return monComportement.toString() + " " + String.format("p= %,6.2f", p * 100);

    }

    @Override
    public Envie clone() {
        return new Envie(monComportement, p);
    }

}
