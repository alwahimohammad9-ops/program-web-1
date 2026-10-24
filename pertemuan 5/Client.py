import socket  
HOST = "127.0.0.1"  
PORT = 5000        


DAFTAR_PERINTAH = (
    "Daftar perintah yang tersedia:\n"
    "  BANTUAN : menampilkan daftar perintah ini\n"
    "  QUIT    : mengakhiri komunikasi\n"
    "  (teks lain) : server akan membalas dengan pesan yang Anda kirim"
)


server_socket = socket.socket(
    socket.AF_INET,
    socket.SOCK_STREAM
)


server_socket.bind((HOST, PORT))


server_socket.listen(1)


print(f"Server berjalan di {HOST}:{PORT}")
print("Menunggu client terhubung...")

try:
   
    conn, address = server_socket.accept()
    print("Client terhubung:", address)

    
    jumlah_pesan = 0

   
    with conn:
        while True:
            
            data = conn.recv(1024)

           
            if not data:
                print("Client menutup koneksi.")
                break  

            pesan = data.decode("utf-8")
            print("Pesan dari client:", pesan)

           
            if pesan.strip().upper() == "QUIT":
            
                balasan = (
                    "Sampai jumpa. Koneksi diakhiri. "
                    f"Total pesan diterima sebelum QUIT: {jumlah_pesan}"
                )

             
                conn.sendall(balasan.encode("utf-8"))

                print("Perintah QUIT diterima.")
                print(f"Total pesan diterima sebelum QUIT: {jumlah_pesan}")
                break 
            jumlah_pesan += 1

            
            if pesan.strip().upper() == "BANTUAN":
                balasan = DAFTAR_PERINTAH
            else:
               
                balasan = "Server menerima: " + pesan

           
            conn.sendall(balasan.encode("utf-8"))

finally:

    server_socket.close()


    print("Server berhenti.")