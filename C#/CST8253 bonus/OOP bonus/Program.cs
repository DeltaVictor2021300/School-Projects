using System.Security.Cryptography.X509Certificates;

namespace OOP_bonus
{
    class main
    {
        static void Main(string[] args)
        {
            string name;
            Console.Write("Please enter account name: ");
            name = Console.ReadLine();

            Checking userCheck = new Checking(name, 0.00);
            Saving userSave = new Saving(name, 0.00);
            List<string> checkRecords = new List<string>();
            List<string> saveRecords = new List<string>();
            checkRecords.Add("Amount\tDate\tAction");
            saveRecords.Add("Amount\tDate\tAction");

            //userCheck.deposit(1000.00);
            //userCheck.withdraw(200.00);
            //Console.WriteLine(userCheck.lastWithdraw);

            static void BalanceEnquiry(double checkings, double savings) //Balance Enquiry
            {
                Console.Write(String.Format("Checkings Balance: {0} Savings Balance: {1}", checkings, savings));
                Console.WriteLine();
            }

            static void Transfer(Account reciever, Account sender, double amount) //Transfer
            {
                try
                {
                    sender.withdraw(amount);
                    reciever.deposit(amount);
                }
                catch
                {
                    Console.WriteLine("error");
                }
            }



            //BalanceEnquiry(userCheck.balance, userSave.balance);
            //Transfer(userSave, userCheck, 400.00);
            //BalanceEnquiry(userCheck.balance, userSave.balance);

            bool loop = true; //main loop
            while (loop)
            {
                int? choice = null; //menu
                Console.WriteLine("Please Select an option:");
                Console.WriteLine("1. Deposit");
                Console.WriteLine("2. Withdraw");
                Console.WriteLine("3. Transfer");
                Console.WriteLine("4. Account Activity Enquiry");
                Console.WriteLine("5. Balance Enquiry");
                Console.WriteLine("6. Exit");
                choice = int.Parse(Console.ReadLine());

                switch (choice) 
                {
                    case 1: //deposit selection
                        Console.WriteLine("please select an account: savings:1, checking:2 ");
                        int choice1 = 0;
                        choice1 = int.Parse(Console.ReadLine());
                        double depositAmount = 0.00;
                        Console.WriteLine("please enter a deposit amount");
                        depositAmount = double.Parse(Console.ReadLine());
                        if (choice1 == 1)
                        {
                            userSave.deposit(depositAmount);
                            saveRecords.Add(depositAmount.ToString() + "\t" + DateTime.Now + "\t" + "Deposit");
                            saveRecords.Add((depositAmount * 0.03).ToString() + "\t" + DateTime.Now + "\t" + "Interest");
                        }
                        else if(choice1 == 2)
                        {
                            userCheck.deposit(depositAmount);
                            checkRecords.Add(depositAmount.ToString() + "\t" + DateTime.Now + "\t" + "Deposit");
                        }
                        break;
                    case 2: //withdraw selection
                        Console.WriteLine("please select an account: savings:1, checking:2 ");
                        int choice2 = 0;
                        choice1 = int.Parse(Console.ReadLine());
                        double withdrawAmount = 0.00;
                        Console.WriteLine("please enter a withdraw amount");
                        withdrawAmount = double.Parse(Console.ReadLine());
                        if (choice1 == 1)
                        {
                            try
                            {
                                userSave.withdraw(withdrawAmount);
                                saveRecords.Add(withdrawAmount.ToString() + "\t" + DateTime.Now + "\t" + "Withdraw");
                                saveRecords.Add("10" + "\t" + DateTime.Now + "\t" + "Penalty");
                            }
                            catch
                            {

                            }
                        }
                        else if (choice1 == 2)
                        {
                            try
                            {
                                userCheck.withdraw(withdrawAmount);
                                checkRecords.Add(withdrawAmount.ToString() + "\t" + DateTime.Now + "\t" + "Withdraw");
                            } catch
                            {

                            }
                        }
                        break;
                    case 3: //transfer selection
                        int choice3 = 0;
                        Console.WriteLine("which account will you transfer to? savings:1, checking:2 ");
                        choice3 = int.Parse(Console.ReadLine());
                        double transAmount = 0.00;
                        Console.WriteLine("How much would you like to transfer?");
                        transAmount = double.Parse(Console.ReadLine());
                        if (choice3 == 1)
                        {
                            Transfer(userSave, userCheck, transAmount);
                            saveRecords.Add(transAmount.ToString() + "\t" + DateTime.Now + "\t" + "Transfer In");
                            checkRecords.Add(transAmount.ToString() + "\t" + DateTime.Now + "\t" + "Transfer Out");
                        }
                        else if(choice3 == 2)
                        {
                            Transfer(userCheck, userSave, transAmount);
                            saveRecords.Add(transAmount.ToString() + "\t" + DateTime.Now + "\t" + "Transfer Out");
                            checkRecords.Add(transAmount.ToString() + "\t" + DateTime.Now + "\t" + "Transfer In");
                        }
                        break;
                    case 4: //activity log
                        Console.WriteLine("Savings log");
                        for(int i = 0; i < saveRecords.Count(); i++)
                        {
                            Console.WriteLine(saveRecords[i]);
                        }
                        Console.WriteLine("Checkings log");
                        for (int i = 0; i < checkRecords.Count(); i++)
                        {
                            Console.WriteLine(checkRecords[i]);
                        }
                        break;
                    case 5: // balance enquiry
                        BalanceEnquiry(userCheck.balance, userSave.balance);
                        break;
                    case 6: //exit
                        loop = false;
                        break;
                }
            }
        }
    }
}