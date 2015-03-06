import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;
import java.util.Random;
import javax.swing.JFrame;
import javax.swing.JPanel;

	
public class Display extends JPanel{

    	JFrame frame;
    	Random random;
    	
    	double x;
    	double y;
    	double xBuff;
    	double yBuff;
    	String coordinates; 
    	
    	public Display(){
    		
    		super();
    		
    		frame = new JFrame();
    		 
    		x = 500;
    		y = 500;
    		
    		xBuff = -100;
    		yBuff = -100;
    		
    	    //this.setOpaque(false);
    		this.setPreferredSize(new Dimension(1400,800));
    		 
    		this.setBackground(Color.GRAY);
    		//this.setBackground(new Color(0, 0, 0, 0));
    		this.setBackground(Color.GRAY);
    		this.setVisible(true);
    		
    		frame.setSize(new Dimension(1400,800));
    		frame.add(this);
    		frame.setUndecorated(true);
    		frame.pack();
    		
    		frame.setBackground(new Color(0, 0, 0, 0));
    		frame.setVisible(true);
    		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    	
    	}
    	
    	@Override
    	public void paintComponent(Graphics graphics)
    	{
    		super.paintComponent(graphics);
    		
    		graphics.setColor(Color.blue);
    		graphics.setColor(Color.green);
    		graphics.fillOval((int) (x), (int)(y), 50, 50);
    	
    	}
    	
    	public void setCoordinates(double x, double y){
    		this.x = x  + xBuff;
    		this.y = y  + yBuff;
    	}
    	
    }
