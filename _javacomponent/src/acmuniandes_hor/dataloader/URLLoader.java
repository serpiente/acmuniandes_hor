package acmuniandes_hor.dataloader;

import java.io.IOException;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class URLLoader {
	
	private final static String BASE_URL = "http://registroapps.uniandes.edu.co";
	
	public static final String URL_DEPTOS = "http://registroapps.uniandes.edu.co/scripts/adm_con_horario_joomla.php";
	public static final String URL_HORARIOS = "http://registro.uniandes.edu.co/index.php/elaboracion-de-horario/";
	public static final String URL_CBU = "http://cbu.uniandes.edu.co/index.php";
	public static final String DEPT_SELECTOR_QUERY = "font.texto4 > a";
	
	private String[] departamentos;
	//private String[] codDepartamentos;
	private String[] urls;
	private int numdeptos;
	
	public URLLoader(){
		//this.codDepartamentos = new String[NUM_DEPTOS];
		loadDepartamentos();
	}

	/**
	 * 
	 */
	public void comence() {
//		DataLoader dl = new DataLoader("IIND", "http://registroapps.uniandes.edu.co/scripts/adm_con_horario1_joomla.php?depto=IIND");
//		dl.run();
		while (true) {
			long s = System.currentTimeMillis();
			for (int i = 0; i < this.numdeptos; i++) {
				DataLoader dl = new DataLoader(this.departamentos[i], this.urls[i]);
				dl.run();
//				new Thread(dl).start();
			}
			System.out.println("TOTAL DURATION SEQUENTIAL: "+(System.currentTimeMillis() - s));
			try {
				Thread.sleep(60000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
	}

	private void loadDepartamentos(){
		// TODO CARGAR INTELIGENTEMENTE LOS DEPARTAMENTOS
		try {
			Document doc = Jsoup.connect(URL_DEPTOS).get();
			Elements links = doc.select(DEPT_SELECTOR_QUERY);
			this.numdeptos = links.size();
			this.departamentos = new String[numdeptos];
			this.urls = new String[numdeptos];
			
			for(int i=0; i<this.numdeptos;i++) {
				Element link = links.get(i);
				this.departamentos[i] = link.text();
				String href = link.attr("href");
				this.urls[i] = BASE_URL + href.substring(2,href.indexOf('&'));
			}
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
}
