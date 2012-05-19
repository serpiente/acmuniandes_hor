package acmuniandes_hor.entidades;

public class Ocurrencia {
	
	public final static char L = 'L';
	public final static char M = 'M';
	public final static char I = 'I';
	public final static char J = 'J';
	public final static char V = 'V';
	public final static char S = 'S';
	public final static char D = 'D';
	
	private String dia;
	
	private String horaInicio;
	
	private String horaFin;
	
	private String salon;
	
	private int unidadesDuracion;
	
	private String fechaInicial;
	
	private String fechaFinal;
	
	public Ocurrencia(){
		
	}

	public String getDia() {
		return dia;
	}

	public void setDia(String dia) {
		this.dia = dia;
	}

	public String getHoraInicio() {
		return horaInicio;
	}

	public void setHoraInicio(String horaInicio) {
		this.horaInicio = horaInicio;
	}

	public String getHoraFin() {
		return horaFin;
	}

	public void setHoraFin(String horFin) {
		this.horaFin = horFin;
	}

	public String getSalon() {
		return salon;
	}

	public void setSalon(String salon) {
		this.salon = salon;
	}

	public int getUnidadesDuracion() {
		return unidadesDuracion;
	}

	public void setUnidadesDuracion(int unidadesDuracion) {
		this.unidadesDuracion = unidadesDuracion;
	}
	
	public String getFechaInicial() {
		return fechaInicial;
	}

	public void setFechaInicial(String fechaInicial) {
		this.fechaInicial = fechaInicial;
	}

	public String getFechaFinal() {
		return fechaFinal;
	}

	public void setFechaFinal(String fechaFinal) {
		this.fechaFinal = fechaFinal;
	}

	@Override
	public String toString(){
		String asw = ">>"+this.dia+"--"+this.horaInicio+"--"+this.horaFin+"--"+this.salon+"--Fecha Inicio: "+this.fechaInicial+"--Fecha Fin: "+this.fechaFinal+"<<";
		return asw;
	}
}
