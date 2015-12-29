Public Class Member
    Public Name As String
    Public Rank As String
    Public Joined As String

    Public Sub New(name As String, rank As String, joined As String)
        Me.Name = name
        Me.Rank = rank
        Me.Joined = joined
    End Sub
End Class