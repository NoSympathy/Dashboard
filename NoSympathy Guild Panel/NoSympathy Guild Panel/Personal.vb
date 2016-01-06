Imports APIControllers
Imports Models
Imports pvpstats

Public Class Personal

    Private Function GetMyInfo() As Account

        Dim acc_controller = New AccountControllers()
        Dim char_controller = New CharacterController()
        Dim account = acc_controller.GetAccount(My.Settings.APIKey)
        Dim characters = char_controller.GetCharacters(My.Settings.APIKey)


        account.Characters = characters
        Return account
    End Function



    Private Sub Personal_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        If (My.Settings.APIKey.Trim() = "") Then
            If (MessageBox.Show("Add your API key first") = DialogResult.OK) Then
                Settings.Show()
            End If
        Else
            Dim account = GetMyInfo()
            lblAccount.Text = "Welcome, " + account.Name
            DataGridView1.DataSource = account.Characters
        End If

    End Sub


    Private Sub TabPage2_Click(sender As Object, e As EventArgs) Handles TabPage2.Click
        ' PvP Info (wins (number) losses(Number), desertions(Number), byes(Number), forfeits(Number)
        If (My.Settings.APIKey.Trim() = "") Then
            If (MessageBox.Show("Add your API key first") = DialogResult.OK) Then
                Settings.Show()
            End If
        Else




        End If
    End Sub




    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Me.Close()
    End Sub


End Class