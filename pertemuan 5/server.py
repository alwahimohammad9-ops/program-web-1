import socket  


HOST = "127.0.0.1"  
PORT = 5000         


client_socket = socket.socket(
    socket.AF_INET,
    socket.SOCK_STREAM
)


jumlah_balasan = 0

try:
    
    client_socket.connect((HOST, PORT))

   
    print("Berhasil terhubung ke server.")
    print("Ketik pesan untuk dikirim.")
    print("Ketik BANTUAN untuk melihat daftar perintah.")
    print("Ketik QUIT untuk mengakhiri komunikasi.")


    while True:
       
        pesan = input("Anda: ")

        
        client_socket.sendall(
            pesan.encode("utf-8")
        )

        
        balasan = client_socket.recv(1024)

       
        if not balasan:
            print("Server menutup koneksi.")
            break  
        jumlah_balasan += 1

    
    
        print(f"Balasan server (ke-{jumlah_balasan}):", balasan.decode("utf-8"))

      
        if pesan.strip().upper() == "QUIT":
            break  

finally:
  
    client_socket.close()


    print(f"Total balasan yang diterima: {jumlah_balasan}")


    print("Client berhenti.")