package kiosques;

import kiosques.IParcPosition;

/**
 *
 * @author sylvain
 */
public class AbstractParcPosition implements IParcPosition {

    private int maPos;
    public static final int PREMIEREPOSITION = 1, DERNIEREPOSITION=7;
    
    public AbstractParcPosition() {
        this(PREMIEREPOSITION);
    }

    public AbstractParcPosition(int i) {
        setMaPos(i);
    }

    @Override
    public int getMaPos() {
        return maPos;
    }

    public void setMaPos(int i) {
        if (i <= DERNIEREPOSITION) {
            if (i >= PREMIEREPOSITION) {
                maPos = i;
            } else {
                maPos = PREMIEREPOSITION;
            }
        } else {
            maPos = DERNIEREPOSITION;
        }
    }

    @Override
    public void next() {
        setMaPos(maPos + 1);
    }

    @Override
    public void previous() {
        setMaPos(maPos - 1);
    }

}
