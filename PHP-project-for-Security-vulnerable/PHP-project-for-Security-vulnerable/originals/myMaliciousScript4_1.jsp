<%@page import="java.io.*"%> 
<%@page import="java.net.*"%> 
 
<HTML> 
<% 
//creating a file into a specific location: here nazrul is my user name.... 
File file = new File("C:/Users/emmet/OneDrive/Desktop/CST8265 lab7/getInformations.txt"); 
file.createNewFile(); 
Writer w = new BufferedWriter(new FileWriter(file)); 
 
//to write text into a txt file 
w.write("Test message\r\n"); 
 
//to get host name... using JSP’s request object 
String hostName = request.getServerName(); 
InetAddress inetAddress = InetAddress.getLocalHost();// 
String ip = inetAddress.getHostAddress(); 
 
//writing host name and IP into the text file 
w.write(hostName+"\r\n------------------------\r\n"+ip + "\r\n"); 
 
//--------------- route table 
/* 
On Linux and UNIX systems, information on how packets are to be forwarded is 
stored in a kernel structure called a routing table. You need to manipulate 
this table when configuring your computer to talk to other computers across a 
network. 
*/ 
 
Process pro = Runtime.getRuntime().exec("route print"); 
 
try { 
 
BufferedReader bufferedReader = new BufferedReader(new 
InputStreamReader(pro.getInputStream())); 
 
String line; 
 
//To write line by line 
while((line = bufferedReader.readLine())!=null){ 
w.write(line+"\r\n"); 
  } 
} catch(IOException e) { 
out.println(e.getMessage()); 
} 
 
w.flush(); 
w.close(); 
 
 
//to write into console 
System.out.println("\r\nwelcome to java world "); 
 
 
 
 
//to write into webpage as output 
out.println("Welcome to java world</br>"); 
out.println(hostName+"</br>"); 
out.println("--------------------------</br>"); 
out.println(ip); 
 
%> 
</HTML> 
