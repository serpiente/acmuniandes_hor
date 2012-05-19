package acmuniandes_hor.entidades;

import java.util.ArrayList;

public class Curso {
	
	public final static char A = 'A';
	public final static char B = 'B';
	public final static char E = 'E';
	
	private int capacidad;

	private int disponibles;
	
	private int inscritos;
	
	private String codigo;
	
	private double creditos;
	
	private String crn;
	
	private String departamento;
	
	private String titulo;
	
	private int seccion;
	
	private char tipo;
	
	private ArrayList<Curso> complementarias;
	
	private ArrayList<Ocurrencia> ocurrencias;
	
	private ArrayList<String> profesores;
	
	private String dias;
	
	private int numcompl;
	
	public Curso(){
		
	}

	public int getCapacidad() {
		return capacidad;
	}

	public void setCapacidad(int capacidad) {
		this.capacidad = capacidad;
	}

	public int getDisponibles() {
		return disponibles;
	}

	public void setDisponibles(int disponibles) {
		this.disponibles = disponibles;
	}

	public int getInscritos() {
		return inscritos;
	}

	public void setInscritos(int inscritos) {
		this.inscritos = inscritos;
	}

	public String getCodigo() {
		return codigo;
	}

	public void setCodigo(String codigo) {
		this.codigo = codigo;
	}

	public double getCreditos() {
		return creditos;
	}

	public void setCreditos(double creditos) {
		this.creditos = creditos;
	}

	public String getCrn() {
		return crn;
	}

	public void setCrn(String crn) {
		this.crn = crn;
	}

	public String getDepartamento() {
		return departamento;
	}

	public void setDepartamento(String departamento) {
		this.departamento = departamento;
	}

	public String getTitulo() {
		return titulo;
	}

	public void setTitulo(String titulo) {
		this.titulo = titulo;
	}

	public int getSeccion() {
		return seccion;
	}

	public void setSeccion(int seccion) {
		this.seccion = seccion;
	}

	public char getTipo() {
		return tipo;
	}

	public void setTipo(char tipo) {
		this.tipo = tipo;
	}

	public ArrayList<Curso> getComplementarias() {
		return complementarias;
	}

	public void setComplementarias(ArrayList<Curso> complementarias) {
		this.complementarias = complementarias;
	}

	public ArrayList<Ocurrencia> getOcurrencias() {
		return ocurrencias;
	}

	public void setOcurrencias(ArrayList<Ocurrencia> ocurrencias) {
		this.ocurrencias = ocurrencias;
	}

	public ArrayList<String> getProfesores() {
		return profesores;
	}

	public void setProfesores(ArrayList<String> profesores) {
		this.profesores = profesores;
	}

	public String getDias() {
		return dias;
	}

	public void setDias(String dias) {
		this.dias = dias;
	}

	public int getNumcompl() {
		return numcompl;
	}

	public void setNumcompl(int numcompl) {
		this.numcompl = numcompl;
	}
	
	@Override
	public String toString(){
		String asw = "Curso: "+this.titulo+"\n";
		asw += "crn: "+this.crn+"\n";
		asw += "capacidad: "+this.capacidad+"\n";
		asw += "disponibles: "+this.disponibles+"\n";
		asw += "inscritos: "+this.inscritos+"\n";
		asw += "codigo: "+this.codigo+"\n";
		asw += "creditos: "+this.creditos+"\n";
		asw += "departamento: "+this.departamento+"\n";
		asw += "seccion: "+this.seccion+"\n";
		
		if (ocurrencias != null) {
			for (int i = 0; i < ocurrencias.size(); i++) {
				asw += this.ocurrencias.get(i).toString() + "\n";
			}
		}
		if (profesores != null) {
			for (int i = 0; i < profesores.size(); i++) {
				asw += "profesor: "+this.profesores.get(i) + "\n";
			}
		}
		asw += "dias: "+this.dias+"\n";	
		asw += "----------------------FIN----------------------";
		return asw;
	}

}
